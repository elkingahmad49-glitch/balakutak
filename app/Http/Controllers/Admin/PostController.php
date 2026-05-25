<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\Gallery;

class PostController extends Controller
{
    use \App\Traits\HasMedia;
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category'])
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->when($request->month, function($q) use ($request) {
                return $q->whereMonth(\DB::raw('COALESCE(published_at, created_at)'), $request->month);
            })
            ->when($request->year, function($q) use ($request) {
                return $q->whereYear(\DB::raw('COALESCE(published_at, created_at)'), $request->year);
            })
            ->orderByRaw('COALESCE(published_at, created_at) DESC');

        // Editors & Dosens only see their own posts
        if (!auth()->user()->hasRole(['Super Admin', 'Admin Prodi'])) {
            $query->where('user_id', auth()->id());
        }

        $posts = $query->paginate(15)->withQueryString();
        $categories = Category::all();

        // Get list of distinct years for filtering
        $years = Post::selectRaw('YEAR(COALESCE(published_at, created_at)) as year')
            ->whereNotNull('created_at')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->filter()
            ->toArray();

        $months = [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        return view('admin.posts.index', compact('posts', 'categories', 'years', 'months'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'sdgs' => 'nullable|array',
            'type' => 'required|in:post,news,research,community',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'allow_comments' => 'boolean',
            'featured_image' => 'nullable|string',
            'featured_image_file' => 'nullable|image|max:4096',
            'published_at' => 'nullable|date',
            'seo_title' => 'nullable|string|max:60',
            'seo_description' => 'nullable|string|max:160',
            'seo_keywords' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:5',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($validated['title']);

        $published_at = $validated['published_at'] ?? now();
        if ($validated['status'] !== 'published') {
            $published_at = null;
        }

        $post = Post::create([
            ...$validated,

            'user_id' => auth()->id(),
            'slug' => $slug,
            'language' => $request->language ?? 'id',
            'is_featured' => $request->boolean('is_featured'),
            'allow_comments' => $request->boolean('allow_comments', true),
            'published_at' => $published_at,
            'seo_meta' => [
                'title' => $request->seo_title,
                'description' => $request->seo_description,
                'keywords' => $request->seo_keywords,
            ],
        ]);

        // Handle Image via HasMedia logic
        \Illuminate\Support\Facades\Log::info("Post created: ID={$post->id}, Title={$post->title}");
        $path = $this->handleMedia('featured_image', 'posts', $post->title);
        \Illuminate\Support\Facades\Log::info("handleMedia returned Path: " . ($path ?? 'NULL'));
        
        if ($path) {
            $post->update(['featured_image' => $path]);
            $this->syncToGallery($post, $path, 'Imported');
        }


        if ($request->tags) {
            $tagIds = [];
            foreach ($request->tags as $tagInput) {
                if (is_numeric($tagInput)) {
                    $tagIds[] = $tagInput;
                }
                else {
                    $newTag = Tag::firstOrCreate([
                        'name' => $tagInput,
                        'slug' => Str::slug($tagInput)
                    ]);
                    $tagIds[] = $newTag->id;
                }
            }
            $post->tags()->sync($tagIds);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel berhasil disimpan!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'xml_file' => 'required|file|mimetypes:text/xml,application/xml|max:51200'
        ]);

        // Increase max execution time for large imports
        ini_set('max_execution_time', 300);

        $file = $request->file('xml_file');

        libxml_use_internal_errors(true);
        $xml = simplexml_load_file($file->getRealPath());

        if (!$xml) {
            return back()->withErrors(['xml_file' => 'Format file XML tidak valid atau rusak.']);
        }

        $namespaces = $xml->getNamespaces(true);
        $wpNamespace = $namespaces['wp'] ?? 'http://wordpress.org/export/1.2/';
        $contentNamespace = $namespaces['content'] ?? 'http://purl.org/rss/1.0/modules/content/';

        $importedCount = 0;
        $defaultCategory = Category::firstOrCreate([
            'name' => 'Berita & Informasi',
            'slug' => 'berita-informasi'
        ]);

        foreach ($xml->channel->item as $item) {
            $wpMeta = $item->children($wpNamespace);

            // Only import posts
            if ((string)$wpMeta->post_type === 'post') {
                $title = (string)$item->title;
                $slug = (string)$wpMeta->post_name ?: Str::slug($title);

                // Content mapped from <content:encoded>
                $contentNode = $item->children($contentNamespace);
                $content = (string)$contentNode->encoded;

                // If content is empty or short, we might skip or still import
                if (empty(trim($title)))
                    continue;

                $status = (string)$wpMeta->status === 'publish' ? 'published' : 'draft';
                $postDate = (string)$wpMeta->post_date;
                $publishedAt = ($postDate && $postDate !== '0000-00-00 00:00:00') ?\Carbon\Carbon::parse($postDate) : now();

                // Categorization
                $categoryId = $defaultCategory->id;
                foreach ($item->category as $cat) {
                    if ((string)$cat['domain'] === 'category') {
                        $catName = (string)$cat;
                        // Avoid empty categories
                        if (!empty(trim($catName))) {
                            $catSlug = Str::limit(Str::slug($catName), 255, '');
                            $dbCategory = Category::where('name', $catName)
                                ->orWhere('slug', $catSlug)
                                ->first();

                            if (!$dbCategory) {
                                $dbCategory = Category::create([
                                    'name' => Str::limit($catName, 255, ''),
                                    'slug' => $catSlug
                                ]);
                            }
                            $categoryId = $dbCategory->id;
                            break; // prioritize first found category
                        }
                    }
                }

                $postSlug = $slug;

                // Download all images in content and update URLs
                $content = $this->processImportContentImages($content);

                // Extract featured image from content if exists
                $featuredImage = null;
                if (preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $content, $imageMatch)) {
                    $localUrl = $imageMatch['src'];
                    $storageUrl = Storage::disk('public')->url('');
                    $featuredImage = str_replace($storageUrl, '', $localUrl);
                }

                $post = Post::create([
                    'user_id' => auth()->id(),
                    'title' => Str::limit($title, 255, ''),
                    'slug' => $postSlug,
                    'content' => $content,
                    'excerpt' => Str::limit(strip_tags($content), 200),
                    'category_id' => $categoryId,
                    'type' => 'news',
                    'status' => $status,
                    'published_at' => $publishedAt,
                    'featured_image' => $featuredImage,
                ]);

                // Create Gallery entry for featured image
                if ($featuredImage) {
                    $this->syncToGallery($post, $featuredImage, 'Imported');
                }

                $importedCount++;
            }
        }

        return redirect()->route('admin.posts.index')
            ->with('success', "Berhasil mengimpor {$importedCount} artikel dari XML.");
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        $selectedTags = $post->tags->pluck('id')->toArray();
        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'selectedTags'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|array',
            'sdgs' => 'nullable|array',
            'type' => 'required|in:post,news,research,community',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'allow_comments' => 'boolean',
            'featured_image' => 'nullable|string',
            'featured_image_file' => 'nullable|image|max:4096',
            'published_at' => 'nullable|date',
            'seo_title' => 'nullable|string|max:60',
            'seo_description' => 'nullable|string|max:160',
            'seo_keywords' => 'nullable|string|max:255',
        ]);


        $published_at = $validated['published_at'] ?? $post->published_at;
        if ($validated['status'] !== 'published') {
            $published_at = null;
        }
        elseif (!$published_at) {
            $published_at = now();
        }

        $path = $this->handleMedia('featured_image', 'posts', $post->title);

        $postData = [
            ...$validated,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($validated['title']),
            'is_featured' => $request->boolean('is_featured'),
            'allow_comments' => $request->boolean('allow_comments', true),
            'published_at' => $published_at,
            'seo_meta' => [
                'title' => $request->seo_title,
                'description' => $request->seo_description,
                'keywords' => $request->seo_keywords,
            ],
        ];

        if ($path) {
            $postData['featured_image'] = $path;
            $this->syncToGallery($post->fill(['title' => $request->title]), $path, 'Imported');
        }

        $post->update($postData);

        $tagIds = [];
        if ($request->tags) {
            foreach ($request->tags as $tagInput) {
                if (is_numeric($tagInput)) {
                    $tagIds[] = $tagInput;
                }
                else {
                    $newTag = Tag::firstOrCreate([
                        'name' => $tagInput,
                        'slug' => Str::slug($tagInput)
                    ]);
                    $tagIds[] = $newTag->id;
                }
            }
        }
        $post->tags()->sync($tagIds);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Artikel berhasil dihapus!');
    }

    public function massDestroy(Request $request)
    {
        if (!auth()->user()->hasRole(['Super Admin', 'Admin Prodi'])) {
            abort(403, 'Aksi ini hanya untuk Super Admin dan Admin.');
        }

        $ids = $request->ids;
        if (empty($ids)) {
            return back()->with('error', 'Pilih minimal satu artikel untuk dihapus!');
        }

        Post::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' artikel berhasil dihapus masal!');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function toggleStatus(Post $post)
    {
        $post->update([
            'status' => $post->status === 'published' ? 'draft' : 'published',
            'published_at' => $post->status !== 'published' ? now() : null,
        ]);
        return back()->with('success', 'Status artikel diperbarui!');
    }



    private function processImportContentImages($content)
    {
        return preg_replace_callback('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', function($matches) {
            $src = $matches['src'];
            
            // Skip if already local or internal
            if (str_contains($src, url('')) || str_contains($src, 'storage/') || str_starts_with($src, '/')) {
                return $matches[0];
            }

            $localPath = $this->downloadAndStoreImage($src);
            if ($localPath) {
                $localUrl = Storage::disk('public')->url($localPath);
                return str_replace($src, $localUrl, $matches[0]);
            }

            return $matches[0];
        }, $content);
    }

    private function downloadAndStoreImage($url)
    {
        try {
            if (str_starts_with($url, 'data:image/')) {
                $parts = explode(";base64,", $url);
                if (count($parts) === 2) {
                    $image_type_aux = explode("data:image/", $parts[0]);
                    $image_type = $image_type_aux[1] ?? 'png';
                    $image_base64 = base64_decode($parts[1]);
                    $path = 'gallery/imported-' . Str::random(20) . '.' . $image_type;
                    Storage::disk('public')->put($path, $image_base64);
                    return $path;
                }
            } else {
                $response = \Illuminate\Support\Facades\Http::timeout(20)->get($url);
                if ($response->successful() && str_contains($response->header('Content-Type'), 'image/')) {
                    $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                    $path = 'gallery/imported-' . Str::random(20) . '.' . $ext;
                    Storage::disk('public')->put($path, $response->body());
                    return $path;
                }
            }
        } catch (\Exception $e) {
            // Silent fail, use original URL
        }
        return null;
    }
}
