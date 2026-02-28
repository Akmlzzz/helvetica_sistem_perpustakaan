<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = HeroBanner::orderBy('order_priority', 'asc')->get();
        return view('admin.hero-banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.hero-banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'char_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bg_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'synopsis' => 'nullable|string',
            'tags' => 'nullable|string',
            'target_link' => 'nullable|string',
            'order_priority' => 'integer',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['synopsis', 'tags', 'target_link', 'order_priority', 'is_active']);

        if ($request->hasFile('title_img')) {
            $data['title_img'] = $request->file('title_img')->store('hero/titles', 'public');
        }

        if ($request->hasFile('char_img')) {
            $data['char_img'] = $request->file('char_img')->store('hero/chars', 'public');
        }

        if ($request->hasFile('bg_img')) {
            $data['bg_img'] = $request->file('bg_img')->store('hero/backgrounds', 'public');
        }

        // Set default boolean if not present (checkbox behavior)
        $data['is_active'] = $request->has('is_active');

        HeroBanner::create($data);

        return redirect()->route('admin.hero-banners.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $banner = HeroBanner::findOrFail($id);
        return view('admin.hero-banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $banner = HeroBanner::findOrFail($id);

        $validated = $request->validate([
            'title_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'char_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bg_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'synopsis' => 'nullable|string',
            'tags' => 'nullable|string',
            'target_link' => 'nullable|string',
            'order_priority' => 'integer',
        ]);

        $data = $request->only(['synopsis', 'tags', 'target_link', 'order_priority']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('title_img')) {
            if ($banner->title_img) Storage::disk('public')->delete($banner->title_img);
            $data['title_img'] = $request->file('title_img')->store('hero/titles', 'public');
        }

        if ($request->hasFile('char_img')) {
            if ($banner->char_img) Storage::disk('public')->delete($banner->char_img);
            $data['char_img'] = $request->file('char_img')->store('hero/chars', 'public');
        }

        if ($request->hasFile('bg_img')) {
            if ($banner->bg_img) Storage::disk('public')->delete($banner->bg_img);
            $data['bg_img'] = $request->file('bg_img')->store('hero/backgrounds', 'public');
        }

        $banner->update($data);

        return redirect()->route('admin.hero-banners.index')->with('success', 'Banner berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = HeroBanner::findOrFail($id);
        
        if ($banner->title_img) Storage::disk('public')->delete($banner->title_img);
        if ($banner->char_img) Storage::disk('public')->delete($banner->char_img);
        if ($banner->bg_img) Storage::disk('public')->delete($banner->bg_img);
        
        $banner->delete();

        return redirect()->route('admin.hero-banners.index')->with('success', 'Banner berhasil dihapus.');
    }
}
