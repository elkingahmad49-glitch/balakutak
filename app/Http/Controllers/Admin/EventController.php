<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class EventController extends Controller
{
    use \App\Traits\HasMedia;
    public function index(Request $request)
    {
        $query = Event::with('user')
            ->when($request->search, fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->status === 'published', fn($q) => $q->where('is_published', true))
            ->when($request->status === 'draft', fn($q) => $q->where('is_published', false));

        if (!auth()->user()->hasRole(['Super Admin', 'Admin Prodi'])) {
            $query->where('user_id', auth()->id());
        }

        $events = $query->latest('start_date')->paginate(15)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        Log::info('Event Store Request Started', [
            'request_data' => $request->except(['featured_image', '_token']),
            'has_file' => $request->hasFile('featured_image')
        ]);

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'content' => 'nullable|string',
                'location' => 'required|string|max:255',
                'online_url' => 'nullable|url|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'registration_deadline' => 'nullable|date|before_or_equal:start_date',
                'max_participants' => 'nullable|integer|min:1',
                'is_free' => 'boolean',
                'price' => 'nullable|numeric|min:0',
                'category' => 'nullable|string|max:100',
                'organizer' => 'nullable|string|max:255',
                'contact_person' => 'nullable|string|max:255',
                'registration_url' => 'nullable|url|max:255',
                'featured_image_file' => 'nullable|image|max:10240', // Increased to 10MB to test limits
                'is_published' => 'boolean',
                'seo_title' => 'nullable|string|max:60',
                'seo_description' => 'nullable|string|max:160',
            ]);

            Log::info('Event Validation Passed');

            $slug = Str::slug($validated['title']);

            Log::info('Generated Slug: ' . $slug);

            // Clean event data: exclude non-column and file fields for initial creation
            $eventData = collect($validated)
                ->except(['seo_title', 'seo_description', 'featured_image_file'])
                ->toArray();

            $event = new Event([
                ...$eventData,
                'slug' => $slug,
                'user_id' => auth()->id(),
                'is_free' => $request->has('is_free'),
                'is_published' => $request->has('is_published'),
                'seo_meta' => [
                    'title' => $request->seo_title,
                    'description' => $request->seo_description,
                ],
            ]);

            // Handle Image via HasMedia logic
            $path = $this->handleMedia('featured_image', 'events', $event->title);
            if ($path) {
                $event->featured_image = $path;
                $this->syncToGallery($event, $path, 'Agenda & Kegiatan');
            }

            $event->save();
            Log::info('Event Saved Successfully: ID ' . $event->id);

            return redirect()->route('admin.events.index')
                ->with('success', 'Agenda berhasil ditambahkan!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Event Validation Failed: ', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Event Store Exception: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString()
            ]);
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
        }
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        Log::info('Event Update Request Started: ID ' . $event->id, [
            'request_data' => $request->except(['featured_image', '_token']),
            'has_file' => $request->hasFile('featured_image')
        ]);

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'content' => 'nullable|string',
                'location' => 'required|string|max:255',
                'online_url' => 'nullable|url|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'registration_deadline' => 'nullable|date|before_or_equal:start_date',
                'max_participants' => 'nullable|integer|min:1',
                'is_free' => 'boolean',
                'price' => 'nullable|numeric|min:0',
                'category' => 'nullable|string|max:100',
                'organizer' => 'nullable|string|max:255',
                'contact_person' => 'nullable|string|max:255',
                'registration_url' => 'nullable|url|max:255',
                'featured_image_file' => 'nullable|image|max:10240',
                'is_published' => 'boolean',
                'seo_title' => 'nullable|string|max:60',
                'seo_description' => 'nullable|string|max:160',
            ]);

            Log::info('Event Update Validation Passed');

            // Handle Image via HasMedia logic
            $path = $this->handleMedia('featured_image', 'events', $validated['title']);
            
            $eventData = collect($validated)
                ->except(['seo_title', 'seo_description', 'featured_image_file'])
                ->toArray();

            if ($path) {
                if ($event->featured_image) {
                    Storage::disk('public')->delete($event->featured_image);
                }
                $eventData['featured_image'] = $path;
                $this->syncToGallery($event, $path, 'Agenda & Kegiatan');
            }

            $event->update([
                ...$eventData,
                'is_free' => $request->has('is_free'),
                'is_published' => $request->has('is_published'),
                'seo_meta' => [
                    'title' => $request->seo_title,
                    'description' => $request->seo_description,
                ],
            ]);

            Log::info('Event Updated Successfully: ID ' . $event->id);

            return redirect()->route('admin.events.index')
                ->with('success', 'Agenda berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Event Update Validation Failed: ', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Event Update Exception: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString()
            ]);
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui: ' . $e->getMessage()]);
        }
    }

    public function destroy(Event $event)
    {
        if ($event->featured_image) {
            Storage::disk('public')->delete($event->featured_image);
        }
        $event->delete();

        return back()->with('success', 'Agenda berhasil dihapus!');
    }
}
