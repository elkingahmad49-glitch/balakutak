<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Event;
use App\Models\Lecturer;
use App\Models\Document;
use App\Models\Gallery;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Setting;
use App\Models\ResearchService;
use Illuminate\Http\Request;

class FrontPageController extends Controller
{
    public function about()
    {
        $vision = Setting::get('vision', '');
        $mission = Setting::get('mission', '');
        $greeting = Setting::get('greeting_text', '');
        $headName = Setting::get('greeting_name', '');
        $accreditation = Setting::get('accreditation', '');
        $aboutInstitution = Setting::get('about_institution', '');
        $kaprodiPhoto = Setting::get('kaprodi_photo', '');
        $profileVideoUrl = Setting::get('profile_video_url', '');
        $certAccreditation = Setting::get('cert_accreditation', '');
        $certOthers = json_decode(Setting::get('cert_others', '[]'), true) ?? [];

        // Convert any YouTube URL to embed format
        $videoEmbed = '';
        if ($profileVideoUrl) {
            if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $profileVideoUrl, $m)) {
                $videoEmbed = 'https://www.youtube.com/embed/' . $m[1];
            }
            elseif (str_contains($profileVideoUrl, 'youtube.com/embed/')) {
                $videoEmbed = $profileVideoUrl;
            }
        }

        $page = \App\Models\Page::where('slug', 'tentang-prodi')->first();

        return view('frontend.about', compact(
            'vision', 'mission', 'greeting', 'headName', 'accreditation',
            'aboutInstitution', 'kaprodiPhoto', 'videoEmbed',
            'certAccreditation', 'certOthers', 'page'
        ));
    }

    public function academic()
    {
        return view('frontend.academic');
    }

    public function research(Request $request)
    {
        $page = \App\Models\Page::where('slug', 'penelitian')->first();
        $query = ResearchService::where('type', 'research')->where('is_active', true);
        
        if ($request->filled('q')) {
            $query->where(fn($q) => $q->where('title', 'like', "%{$request->q}%")->orWhere('author', 'like', "%{$request->q}%"));
        }
        
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $posts = $query->orderBy('year', 'desc')->latest()->paginate(20)->withQueryString();
        return view('frontend.research', compact('posts', 'page'));
    }

    public function community(Request $request)
    {
        $page = \App\Models\Page::where('slug', 'pengabdian')->first();
        $query = ResearchService::where('type', 'community_service')->where('is_active', true);
        
        if ($request->filled('q')) {
            $query->where(fn($q) => $q->where('title', 'like', "%{$request->q}%")->orWhere('author', 'like', "%{$request->q}%"));
        }
        
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $posts = $query->orderBy('year', 'desc')->latest()->paginate(20)->withQueryString();
        return view('frontend.community', compact('posts', 'page'));
    }

    public function showResearch($slug)
    {
        $post = ResearchService::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('frontend.research_detail', compact('post'));
    }

    public function search(Request $request)
    {
        $q = $request->input('q', '');
        $results = collect();
        if (strlen($q) >= 3) {
            $results = Post::with('category')
                ->published()
                ->where(fn($query) =>
                    $query->where('title', 'like', "%{$q}%")
                        ->orWhere('excerpt', 'like', "%{$q}%")
                        ->orWhere('content', 'like', "%{$q}%")
                )
                ->latest('published_at')
                ->get(); // Get all posts first for merging

            $events = Event::published()
                ->where(fn($query) =>
                    $query->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhere('location', 'like', "%{$q}%")
                )
                ->latest('start_date')
                ->get();

            // Merge and sort
            $merged = $results->concat($events)->sortByDesc(function($item) {
                return $item->published_at ?? $item->created_at;
            });

            // Convert to manual length aware paginator if needed, 
            // but for simplicity let's just use a large get() or simple paginate
            // Let's stick to Post paginate for now or just increase it to 30 and use simple collection
            $results = new \Illuminate\Pagination\LengthAwarePaginator(
                $merged->forPage($request->input('page', 1), 15),
                $merged->count(),
                15,
                $request->input('page', 1),
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }

        return view('frontend.search', compact('q', 'results'));
    }
}
