<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Shortcode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with('author')->orderBy('sort_order')->latest()->paginate(15);

        return view('admin.pages.index', compact('pages'));
    }

    private function getAvailableShortcodes(): array
    {
        $builtins = [
            ['code' => 'welcome_banner', 'name' => 'Banner Chào Mừng', 'usage' => '[welcome_banner]'],
            ['code' => 'soi_cau_mb', 'name' => 'Soi Cầu Miền Bắc', 'usage' => '[soi_cau_mb]'],
            ['code' => 'cau_dep', 'name' => 'Cầu Đẹp XSMB', 'usage' => '[cau_dep]'],
            ['code' => 'lo_top', 'name' => 'Bảng Lô Top', 'usage' => '[lo_top limit="20"]'],
            ['code' => 'du_doan_cards', 'name' => 'Cards Dự Đoán', 'usage' => '[du_doan_cards]'],
            ['code' => 'kqxs_full', 'name' => 'KQXS Đầy Đủ', 'usage' => '[kqxs_full region="MB"]'],
            ['code' => 'thong_ke_nhanh', 'name' => 'Thống Kê Nhanh', 'usage' => '[thong_ke_nhanh days="30"]'],
            ['code' => 'kqxs_mt_mn', 'name' => 'KQXS MT + MN', 'usage' => '[kqxs_mt_mn]'],
            ['code' => 'thong_ke_lo', 'name' => 'Thống Kê Lô Đề', 'usage' => '[thong_ke_lo days="30"]'],
            ['code' => 'blog_moi', 'name' => 'Bài Viết Mới', 'usage' => '[blog_moi limit="6"]'],
            ['code' => 'kqxs', 'name' => 'KQXS (Compact)', 'usage' => '[kqxs region="MB"]'],
            ['code' => 'soi_cau', 'name' => 'Soi Cầu AI', 'usage' => '[soi_cau]'],
            ['code' => 'thong_ke', 'name' => 'Thống Kê Tần Suất', 'usage' => '[thong_ke days="30"]'],
            ['code' => 'lo_gan', 'name' => 'Lô Gan', 'usage' => '[lo_gan limit="10"]'],
        ];

        $customs = Shortcode::where('is_active', true)->get()->map(fn($s) => [
            'code' => $s->code,
            'name' => $s->name,
            'usage' => "[{$s->code}]",
        ])->toArray();

        return array_merge($builtins, $customs);
    }

    public function create()
    {
        $availableShortcodes = $this->getAvailableShortcodes();
        return view('admin.pages.create', compact('availableShortcodes'));
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
        $availableShortcodes = $this->getAvailableShortcodes();
        return view('admin.pages.edit', compact('page', 'availableShortcodes'));
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
