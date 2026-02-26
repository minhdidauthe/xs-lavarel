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
    </div>

    {{-- Built-in Shortcodes --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
        <div class="p-5 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">
                <i class="fas fa-cube text-blue-500 mr-2"></i>Shortcodes tích hợp
            </h3>
            <p class="text-xs text-gray-400 mt-1">Các shortcode được tích hợp sẵn trong hệ thống, không thể chỉnh sửa</p>
        </div>
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tên</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Cách dùng</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Mô tả</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($builtins as $builtin)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <code class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded font-mono">{{ $builtin['code'] }}</code>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-800">{{ $builtin['name'] }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <code class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded font-mono">{{ $builtin['usage'] }}</code>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500">{{ $builtin['description'] }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Custom Shortcodes --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-gray-800">
                    <i class="fas fa-code text-orange-500 mr-2"></i>Shortcodes tùy chỉnh
                </h3>
                <p class="text-xs text-gray-400 mt-1">Shortcodes do bạn tạo, có thể chỉnh sửa nội dung HTML</p>
            </div>
            <a href="{{ route('admin.shortcodes.create') }}"
               class="bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:shadow-lg transition">
                <i class="fas fa-plus mr-2"></i>Thêm mới
            </a>
        </div>
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tên</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="text-right px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($shortcodes as $shortcode)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-800">{{ $shortcode->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <code class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded font-mono">[{{ $shortcode->code }}]</code>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($shortcode->is_active)
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-green-100 text-green-700">Hoạt động</span>
                            @else
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-gray-100 text-gray-500">Tắt</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.shortcodes.edit', $shortcode) }}"
                                   class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.shortcodes.destroy', $shortcode) }}" method="POST"
                                      class="inline" onclick="return confirm('Bạn có chắc muốn xóa shortcode này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-code text-3xl mb-3"></i>
                                <p class="text-sm">Chưa có shortcode tùy chỉnh nào</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
