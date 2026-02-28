@extends('layouts.admin')

@section('title', 'Quản lý Menu')
@section('page-title', 'Quản lý Menu')

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Quản lý Menu</h2>
            <p class="text-sm text-gray-500 mt-1">Quản lý menu điều hướng trang web</p>
        </div>
        <a href="{{ route('admin.menus.create') }}"
           class="bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:shadow-lg transition">
            <i class="fas fa-plus mr-2"></i>Thêm menu
        </a>
    </div>

    {{-- Menu List --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider w-10">STT</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tên</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">URL</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Icon</th>
                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="text-right px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50" id="menu-list">
                @forelse($menus as $menu)
                    <tr class="hover:bg-gray-50 transition-colors" data-id="{{ $menu->id }}">
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $menu->sort_order }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-800">
                                @if($menu->icon)<i class="{{ $menu->icon }} text-gray-400 mr-2"></i>@endif
                                {{ $menu->title }}
                            </span>
                            @if($menu->css_class)
                                <span class="ml-2 px-1.5 py-0.5 text-[9px] rounded bg-purple-100 text-purple-600">{{ $menu->css_class }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <code class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded font-mono">{{ $menu->url }}</code>
                        </td>
                        <td class="px-6 py-4">
                            @if($menu->icon)
                                <i class="{{ $menu->icon }} text-gray-600"></i>
                                <span class="text-xs text-gray-400 ml-1">{{ $menu->icon }}</span>
                            @else
                                <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($menu->is_active)
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-green-100 text-green-700">Bật</span>
                            @else
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-gray-100 text-gray-500">Tắt</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.menus.edit', $menu) }}"
                                   class="text-blue-500 hover:text-blue-700 text-sm font-medium" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST"
                                      class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa menu này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    {{-- Children --}}
                    @foreach($menu->children as $child)
                    <tr class="hover:bg-gray-50 transition-colors bg-gray-50/50" data-id="{{ $child->id }}">
                        <td class="px-6 py-3 text-sm text-gray-400">{{ $child->sort_order }}</td>
                        <td class="px-6 py-3">
                            <span class="text-sm font-medium text-gray-700 pl-6">
                                <i class="fas fa-level-up-alt fa-rotate-90 text-gray-300 mr-2 text-xs"></i>
                                @if($child->icon)<i class="{{ $child->icon }} text-gray-400 mr-2"></i>@endif
                                {{ $child->title }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <code class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded font-mono">{{ $child->url }}</code>
                        </td>
                        <td class="px-6 py-3">
                            @if($child->icon)
                                <i class="{{ $child->icon }} text-gray-500"></i>
                                <span class="text-xs text-gray-400 ml-1">{{ $child->icon }}</span>
                            @else
                                <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-center">
                            @if($child->is_active)
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-green-100 text-green-700">Bật</span>
                            @else
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-gray-100 text-gray-500">Tắt</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.menus.edit', $child) }}"
                                   class="text-blue-500 hover:text-blue-700 text-sm font-medium" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.menus.destroy', $child) }}" method="POST"
                                      class="inline" onsubmit="return confirm('Xóa menu con này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-bars text-3xl mb-3"></i>
                                <p class="text-sm">Chưa có menu nào</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
