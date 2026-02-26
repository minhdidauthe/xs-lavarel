<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shortcode;
use Illuminate\Http\Request;

class ShortcodeController extends Controller
{
    private array $builtins = [
        ['code' => 'kqxs', 'name' => 'Kết Quả Xổ Số', 'usage' => '[kqxs region="MB"]', 'description' => 'Hiển thị bảng KQXS. Params: region (MB/MN/MT)'],
        ['code' => 'soi_cau', 'name' => 'Soi Cầu AI', 'usage' => '[soi_cau]', 'description' => 'Hiển thị bảng dự đoán AI top 10'],
        ['code' => 'thong_ke', 'name' => 'Thống Kê Tần Suất', 'usage' => '[thong_ke days="30"]', 'description' => 'Hiển thị bảng thống kê tần suất. Params: days, region'],
        ['code' => 'lo_gan', 'name' => 'Lô Gan', 'usage' => '[lo_gan limit="10"]', 'description' => 'Hiển thị bảng lô gan. Params: limit, region'],
    ];

    public function index()
    {
        $builtins = $this->builtins;
        $shortcodes = Shortcode::latest()->get();

        return view('admin.shortcodes.index', compact('builtins', 'shortcodes'));
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
        $validated = $request->validate([
            'name' => 'required|string|max:80',
            'code' => 'required|string|max:60|unique:shortcodes,code,' . $shortcode->id . '|regex:/^[a-z_][a-z0-9_]*$/',
            'content' => 'required|string',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $shortcode->update($validated);

        return redirect()->route('admin.shortcodes.index')->with('success', 'Shortcode đã được cập nhật.');
    }

    public function destroy(Shortcode $shortcode)
    {
        $shortcode->delete();

        return redirect()->route('admin.shortcodes.index')->with('success', 'Shortcode đã được xóa.');
    }
}
