@extends('layouts.admin')

@section('title', 'Shortcodes')
@section('page-title', 'Shortcodes')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Shortcodes</h2>
        <p class="text-sm text-gray-500 mt-1">
            {{ $shortcodes->count() }} shortcode —
            <span class="text-blue-600 font-medium">{{ $shortcodes->where('is_builtin', true)->count() }} hệ thống</span> ·
            <span class="text-orange-500 font-medium">{{ $shortcodes->where('is_builtin', false)->count() }} tùy chỉnh</span>
        </p>
    </div>
    <div class="flex items-center gap-3">
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" id="sc-search" placeholder="Tìm shortcode..."
                   class="pl-8 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-300 w-52">
        </div>
        <a href="{{ route('admin.shortcodes.create') }}"
           class="bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold py-2 px-5 rounded-lg hover:shadow-lg transition text-sm">
            <i class="fas fa-plus mr-1"></i>Thêm mới
        </a>
    </div>
</div>

@php
$colorMap = [
    'blue'   => ['tab_active' => 'bg-blue-600 text-white',   'tab' => 'text-blue-600 hover:bg-blue-50',    'badge' => 'bg-blue-100 text-blue-700'],
    'purple' => ['tab_active' => 'bg-purple-600 text-white', 'tab' => 'text-purple-600 hover:bg-purple-50', 'badge' => 'bg-purple-100 text-purple-700'],
    'pink'   => ['tab_active' => 'bg-pink-500 text-white',   'tab' => 'text-pink-500 hover:bg-pink-50',    'badge' => 'bg-pink-100 text-pink-700'],
    'yellow' => ['tab_active' => 'bg-yellow-500 text-white', 'tab' => 'text-yellow-600 hover:bg-yellow-50', 'badge' => 'bg-yellow-100 text-yellow-700'],
    'orange' => ['tab_active' => 'bg-orange-500 text-white', 'tab' => 'text-orange-500 hover:bg-orange-50', 'badge' => 'bg-orange-100 text-orange-700'],
    'green'  => ['tab_active' => 'bg-green-600 text-white',  'tab' => 'text-green-600 hover:bg-green-50',  'badge' => 'bg-green-100 text-green-700'],
    'red'    => ['tab_active' => 'bg-red-500 text-white',    'tab' => 'text-red-500 hover:bg-red-50',      'badge' => 'bg-red-100 text-red-700'],
    'amber'  => ['tab_active' => 'bg-amber-500 text-white',  'tab' => 'text-amber-600 hover:bg-amber-50',  'badge' => 'bg-amber-100 text-amber-700'],
    'rose'   => ['tab_active' => 'bg-rose-500 text-white',   'tab' => 'text-rose-500 hover:bg-rose-50',    'badge' => 'bg-rose-100 text-rose-700'],
    'indigo' => ['tab_active' => 'bg-indigo-600 text-white', 'tab' => 'text-indigo-600 hover:bg-indigo-50', 'badge' => 'bg-indigo-100 text-indigo-700'],
    'teal'   => ['tab_active' => 'bg-teal-600 text-white',   'tab' => 'text-teal-600 hover:bg-teal-50',   'badge' => 'bg-teal-100 text-teal-700'],
    'cyan'   => ['tab_active' => 'bg-cyan-600 text-white',   'tab' => 'text-cyan-600 hover:bg-cyan-50',   'badge' => 'bg-cyan-100 text-cyan-700'],
    'gray'   => ['tab_active' => 'bg-gray-600 text-white',   'tab' => 'text-gray-600 hover:bg-gray-50',   'badge' => 'bg-gray-100 text-gray-600'],
];
@endphp

{{-- Tab bar --}}
<div class="flex flex-wrap gap-1.5 mb-5" id="tab-bar">
    <button data-tab="all" data-color="bg-gray-800"
            class="tab-btn active-tab px-3 py-1.5 rounded-lg text-xs font-bold transition border border-gray-200 bg-gray-800 text-white"
            onclick="switchTab('all')">
        <i class="fas fa-list mr-1"></i>Tất cả
        <span class="ml-1 px-1.5 py-0.5 rounded-full bg-white/20 text-[10px]">{{ $shortcodes->count() }}</span>
    </button>
    @foreach($groupLabels as $gKey => $gInfo)
        @if(isset($grouped[$gKey]) && $grouped[$gKey]->count() > 0)
        @php $c = $colorMap[$gInfo['color']] ?? $colorMap['gray']; @endphp
        <button data-tab="{{ $gKey }}" data-color="{{ explode(' ', $c['tab_active'])[0] }}"
                class="tab-btn px-3 py-1.5 rounded-lg text-xs font-bold transition border border-gray-200 {{ $c['tab'] }}"
                onclick="switchTab('{{ $gKey }}')">
            <i class="fas {{ $gInfo['icon'] }} mr-1"></i>{{ $gInfo['label'] }}
            <span class="ml-1 px-1.5 py-0.5 rounded-full {{ $c['badge'] }} text-[10px]">{{ $grouped[$gKey]->count() }}</span>
        </button>
        @endif
    @endforeach
</div>

{{-- Search result hint --}}
<div id="search-hint" class="hidden mb-3 text-sm text-gray-500 px-1">
    Tìm thấy <span id="search-count" class="font-bold text-gray-800">0</span> shortcode
</div>

{{-- ── Panel: Tất cả ── --}}
<div id="panel-all" class="tab-panel">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tên & Cách dùng</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Mô tả</th>
                    <th class="text-center px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider hidden md:table-cell">Nhóm</th>
                    <th class="text-center px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Loại</th>
                    <th class="text-center px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Bật/Tắt</th>
                    <th class="text-right px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50" id="tbody-all">
                @forelse($shortcodes as $shortcode)
                @php
                    $scGroup = $shortcode->group ?? 'custom';
                    $scColor = $groupLabels[$scGroup]['color'] ?? 'gray';
                    $scBadge = $colorMap[$scColor]['badge'] ?? $colorMap['gray']['badge'];
                    $scIcon  = $groupLabels[$scGroup]['icon'] ?? 'fa-code';
                    $scLabel = $groupLabels[$scGroup]['label'] ?? 'Tùy chỉnh';
                @endphp
                <tr class="sc-row hover:bg-gray-50 transition-colors"
                    data-code="{{ $shortcode->code }}"
                    data-name="{{ strtolower($shortcode->name) }}">
                    <td class="px-4 py-3">
                        <code class="text-xs {{ $shortcode->is_builtin ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-700' }} px-2 py-1 rounded font-mono">{{ $shortcode->code }}</code>
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-sm font-medium text-gray-800">{{ $shortcode->name }}</div>
                        <code class="text-[10px] bg-gray-100 text-gray-400 px-1.5 py-0.5 rounded font-mono mt-0.5 inline-block">[{{ $shortcode->code }}]</code>
                    </td>
                    <td class="px-4 py-3 hidden lg:table-cell">
                        <span class="text-xs text-gray-500">{{ Str::limit($shortcode->description, 70) }}</span>
                    </td>
                    <td class="px-4 py-3 text-center hidden md:table-cell">
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full {{ $scBadge }}">
                            <i class="fas {{ $scIcon }}"></i> {{ $scLabel }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($shortcode->is_builtin)
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-blue-100 text-blue-700">Hệ thống</span>
                        @else
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-orange-100 text-orange-700">Tùy chỉnh</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <form action="{{ route('admin.shortcodes.toggle', $shortcode) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="cursor-pointer">
                                @if($shortcode->is_active)
                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-green-100 text-green-700 hover:bg-green-200 transition">Bật</span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 transition">Tắt</span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.shortcodes.edit', $shortcode) }}"
                               class="text-blue-500 hover:text-blue-700 text-sm" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(!$shortcode->is_builtin)
                            <form action="{{ route('admin.shortcodes.destroy', $shortcode) }}" method="POST"
                                  class="inline" onsubmit="return confirm('Xóa shortcode này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400 text-sm">Chưa có shortcode nào</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── Panels theo nhóm ── --}}
@foreach($groupLabels as $gKey => $gInfo)
    @php $items = $grouped[$gKey] ?? collect(); @endphp
    @if($items->isEmpty()) @continue @endif
    @php $c = $colorMap[$gInfo['color']] ?? $colorMap['gray']; @endphp

<div id="panel-{{ $gKey }}" class="tab-panel hidden">
    {{-- Group header --}}
    <div class="flex items-center gap-2 mb-3">
        <span class="inline-flex items-center gap-1.5 text-sm font-bold px-3 py-1 rounded-full {{ $c['badge'] }}">
            <i class="fas {{ $gInfo['icon'] }}"></i> {{ $gInfo['label'] }}
        </span>
        <span class="text-xs text-gray-400">{{ $items->count() }} shortcode</span>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tên & Cách dùng</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider hidden md:table-cell">Mô tả</th>
                    <th class="text-center px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Bật/Tắt</th>
                    <th class="text-right px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($items as $shortcode)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3">
                        <code class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded font-mono">{{ $shortcode->code }}</code>
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-sm font-medium text-gray-800">{{ $shortcode->name }}</div>
                        <code class="text-[10px] bg-gray-100 text-gray-400 px-1.5 py-0.5 rounded font-mono mt-0.5 inline-block">[{{ $shortcode->code }}]</code>
                    </td>
                    <td class="px-4 py-3 hidden md:table-cell">
                        <span class="text-xs text-gray-500">{{ $shortcode->description }}</span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <form action="{{ route('admin.shortcodes.toggle', $shortcode) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="cursor-pointer">
                                @if($shortcode->is_active)
                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-green-100 text-green-700 hover:bg-green-200 transition">Bật</span>
                                @else
                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 transition">Tắt</span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.shortcodes.edit', $shortcode) }}"
                               class="text-blue-500 hover:text-blue-700 text-sm" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(!$shortcode->is_builtin)
                            <form action="{{ route('admin.shortcodes.destroy', $shortcode) }}" method="POST"
                                  class="inline" onsubmit="return confirm('Xóa shortcode này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm" title="Xóa">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endforeach

<script>
function switchTab(key) {
    // Reset all tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        const origColor = btn.dataset.origColor;
        btn.className = 'tab-btn px-3 py-1.5 rounded-lg text-xs font-bold transition border border-gray-200 ' + origColor;
    });
    // Hide all panels
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
    // Clear search
    document.getElementById('sc-search').value = '';
    document.getElementById('search-hint').classList.add('hidden');
    document.querySelectorAll('.sc-row').forEach(r => r.style.display = '');

    // Activate selected tab
    const btn = document.querySelector('[data-tab="' + key + '"]');
    if (btn) {
        btn.className = 'tab-btn active-tab px-3 py-1.5 rounded-lg text-xs font-bold transition border ' + btn.dataset.color + ' text-white border-transparent';
    }
    const panel = document.getElementById('panel-' + key);
    if (panel) panel.classList.remove('hidden');
}

// Store original hover colors before any switching
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.dataset.origColor = btn.className
            .split(' ')
            .filter(c => c.startsWith('text-') || c.startsWith('hover:'))
            .join(' ');
    });
});

// Search
document.getElementById('sc-search').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    const hint  = document.getElementById('search-hint');
    const countEl = document.getElementById('search-count');

    if (!q) {
        document.querySelectorAll('.sc-row').forEach(r => r.style.display = '');
        hint.classList.add('hidden');
        return;
    }

    // Switch to "all" panel for search
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
    document.getElementById('panel-all').classList.remove('hidden');
    document.querySelectorAll('.tab-btn').forEach(b => {
        const oc = b.dataset.origColor || '';
        b.className = 'tab-btn px-3 py-1.5 rounded-lg text-xs font-bold transition border border-gray-200 ' + oc;
    });

    let count = 0;
    document.querySelectorAll('#tbody-all .sc-row').forEach(row => {
        const match = (row.dataset.code || '').includes(q) || (row.dataset.name || '').includes(q);
        row.style.display = match ? '' : 'none';
        if (match) count++;
    });

    hint.classList.remove('hidden');
    countEl.textContent = count;
});
</script>

@endsection
