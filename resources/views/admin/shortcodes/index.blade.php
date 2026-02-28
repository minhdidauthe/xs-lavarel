@extends('layouts.admin')

@section('title', 'Shortcodes')
@section('page-title', 'Shortcodes')

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Shortcodes</h2>
            <p class="text-sm text-gray-500 mt-1">Quản lý shortcodes cho bài viết và trang</p>
        </div>
        <a href="{{ route('admin.shortcodes.create') }}"
           class="bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:shadow-lg transition">
            <i class="fas fa-plus mr-2"></i>Thêm mới
        </a>
    </div>

    {{-- All Shortcodes --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tên</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Cách dùng</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Mô tả</th>
                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Loại</th>
                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="text-right px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($shortcodes as $shortcode)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <code class="text-xs {{ $shortcode->is_builtin ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-700' }} px-2 py-1 rounded font-mono">{{ $shortcode->code }}</code>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-800">{{ $shortcode->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <code class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded font-mono">[{{ $shortcode->code }}]</code>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500">{{ Str::limit($shortcode->description, 60) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($shortcode->is_builtin)
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-blue-100 text-blue-700">Hệ thống</span>
                            @else
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-orange-100 text-orange-700">Tùy chỉnh</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.shortcodes.toggle', $shortcode) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="cursor-pointer">
                                    @if($shortcode->is_active)
                                        <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-green-100 text-green-700 hover:bg-green-200 transition">Bật</span>
                                    @else
                                        <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 transition">Tắt</span>
                                    @endif
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.shortcodes.edit', $shortcode) }}"
                                   class="text-blue-500 hover:text-blue-700 text-sm font-medium" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(!$shortcode->is_builtin)
                                <form action="{{ route('admin.shortcodes.destroy', $shortcode) }}" method="POST"
                                      class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa shortcode này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-code text-3xl mb-3"></i>
                                <p class="text-sm">Chưa có shortcode nào</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
