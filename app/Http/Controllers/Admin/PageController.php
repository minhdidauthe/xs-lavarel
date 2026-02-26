<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with('author')->orderBy('sort_order')->latest()->paginate(15);

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:280|unique:pages,slug',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'template' => 'in:default,full-width,sidebar',
            'status' => 'required|in:draft,published',
            'sort_order' => 'integer',
        ]);

        $validated['author_id'] = auth()->id();
        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);

        Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Trang đã được tạo.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:280|unique:pages,slug,' . $page->id,
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'template' => 'in:default,full-width,sidebar',
            'status' => 'required|in:draft,published',
            'sort_order' => 'integer',
        ]);

        $validated['slug'] = $validated['slug'] ?: Str::slug($validated['title']);

        $page->update($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Trang đã được cập nhật.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Trang đã được xóa.');
    }
}
