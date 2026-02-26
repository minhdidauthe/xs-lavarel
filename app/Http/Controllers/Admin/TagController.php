<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('posts')->latest()->get();

        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:80',
            'slug' => 'nullable|string|max:100|unique:tags,slug',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        Tag::create($validated);

        return redirect()->route('admin.tags.index')->with('success', 'Tag đã được tạo.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:80',
            'slug' => 'nullable|string|max:100|unique:tags,slug,' . $tag->id,
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['name']);

        $tag->update($validated);

        return redirect()->route('admin.tags.index')->with('success', 'Tag đã được cập nhật.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('success', 'Tag đã được xóa.');
    }
}
