<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shortcode;
use Illuminate\Http\Request;

class ShortcodeController extends Controller
{
    public function index()
    {
        $shortcodes = Shortcode::orderByDesc('is_builtin')->orderBy('name')->get();

        return view('admin.shortcodes.index', compact('shortcodes'));
    }

    public function create()
    {
        return view('admin.shortcodes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:80',
            'code' => 'required|string|max:60|unique:shortcodes,code|regex:/^[a-z_][a-z0-9_]*$/',
            'content' => 'required|string',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Shortcode::create($validated);

        return redirect()->route('admin.shortcodes.index')->with('success', 'Shortcode đã được tạo.');
    }

    public function edit(Shortcode $shortcode)
    {
        return view('admin.shortcodes.edit', compact('shortcode'));
    }

    public function update(Request $request, Shortcode $shortcode)
    {
        if ($shortcode->is_builtin) {
            // Built-in: only allow name, description, is_active changes
            $validated = $request->validate([
                'name' => 'required|string|max:80',
                'description' => 'nullable|string|max:500',
                'is_active' => 'boolean',
            ]);
            $validated['is_active'] = $request->boolean('is_active', true);
        } else {
            // Custom: allow all field changes
            $validated = $request->validate([
                'name' => 'required|string|max:80',
                'code' => 'required|string|max:60|unique:shortcodes,code,' . $shortcode->id . '|regex:/^[a-z_][a-z0-9_]*$/',
                'content' => 'required|string',
                'description' => 'nullable|string|max:500',
                'is_active' => 'boolean',
            ]);
            $validated['is_active'] = $request->boolean('is_active', true);
        }

        $shortcode->update($validated);

        return redirect()->route('admin.shortcodes.index')->with('success', 'Shortcode đã được cập nhật.');
    }

    public function toggle(Shortcode $shortcode)
    {
        $shortcode->update(['is_active' => !$shortcode->is_active]);

        $status = $shortcode->is_active ? 'bật' : 'tắt';
        return redirect()->route('admin.shortcodes.index')->with('success', "Shortcode [{$shortcode->code}] đã được {$status}.");
    }

    public function destroy(Shortcode $shortcode)
    {
        if ($shortcode->is_builtin) {
            return redirect()->route('admin.shortcodes.index')->with('error', 'Không thể xóa shortcode hệ thống.');
        }

        $shortcode->delete();

        return redirect()->route('admin.shortcodes.index')->with('success', 'Shortcode đã được xóa.');
    }
}
