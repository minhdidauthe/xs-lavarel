<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('children')
            ->topLevel()
            ->orderBy('sort_order')
            ->get();

        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $parents = Menu::topLevel()->orderBy('sort_order')->get();
        return view('admin.menus.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'url' => 'required|string|max:500',
            'icon' => 'nullable|string|max:100',
            'css_class' => 'nullable|string|max:100',
            'target' => 'in:_self,_blank',
            'match_pattern' => 'nullable|string|max:200',
            'parent_id' => 'nullable|exists:menus,id',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Menu::create($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu đã được tạo.');
    }

    public function edit(Menu $menu)
    {
        $parents = Menu::topLevel()->where('id', '!=', $menu->id)->orderBy('sort_order')->get();
        return view('admin.menus.edit', compact('menu', 'parents'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'url' => 'required|string|max:500',
            'icon' => 'nullable|string|max:100',
            'css_class' => 'nullable|string|max:100',
            'target' => 'in:_self,_blank',
            'match_pattern' => 'nullable|string|max:200',
            'parent_id' => 'nullable|exists:menus,id',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $menu->update($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu đã được cập nhật.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu đã được xóa.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menus,id',
            'items.*.sort_order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            Menu::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }
}
