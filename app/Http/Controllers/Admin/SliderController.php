<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    use \App\Traits\HasMedia;
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|string',
            'image_file' => 'nullable|image|max:4096',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $slider = new Slider();
        $slider->title = $validated['title'];
        $slider->subtitle = $validated['subtitle'];
        $slider->button_text = $validated['button_text'] ?? null;
        $slider->button_url = $validated['button_url'] ?? null;
        
        $path = $this->handleMedia('image', 'sliders', $slider->title);
        $slider->image = $path ?? 'placeholder.jpg';
        
        $slider->is_active = $request->has('is_active') ? $request->boolean('is_active') : true;
        $slider->order = $validated['order'] ?? (Slider::max('order') + 1);
        $slider->save();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil ditambahkan!');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|string',
            'image_file' => 'nullable|image|max:4096',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $path = $this->handleMedia('image', 'sliders', $validated['title']);

        $slider->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'button_text' => $validated['button_text'] ?? $slider->button_text,
            'button_url' => $validated['button_url'] ?? $slider->button_url,
            'image' => $path ?? $slider->image,
            'is_active' => $request->boolean('is_active'),
            'order' => $validated['order'] ?? $slider->order,
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider berhasil diperbarui!');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();

        return back()->with('success', 'Slider berhasil dihapus!');
    }

    public function toggleStatus(Slider $slider)
    {
        $slider->update(['is_active' => !$slider->is_active]);

        $status = $slider->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Slider berhasil {$status}!");
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:sliders,id',
            'orders.*.order' => 'required|integer'
        ]);

        foreach ($request->orders as $order) {
            Slider::where('id', $order['id'])->update(['order' => $order['order']]);
        }

        return response()->json(['success' => true]);
    }
}
