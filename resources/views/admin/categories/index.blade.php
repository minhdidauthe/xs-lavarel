@extends('layouts.admin')

@section('title', 'Danh mục')
@section('page-title', 'Danh mục')

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Danh mục</h2>
            <p class="text-sm text-gray-500 mt-1">Quản lý danh mục bài viết</p>
        </div>
        <a href="{{ route('admin.categories.create') }}"
           class="bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:shadow-lg transition">
            <i class="fas fa-plus mr-2"></i>Thêm danh mục
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tên</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Slug</th>
                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Bài viết</th>
                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="text-right px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($categories as $category)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-gray-800">
                                @if($category->parent)
                                    <span class="text-gray-400 mr-1">└</span>
                                    {{ $category->name }}
                                @else
                                    {{ $category->name }}
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <code class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">{{ $category->slug }}</code>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm text-gray-600">{{ $category->posts_count }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($category->is_active)
                                <span class="inline-block w-2.5 h-2.5 bg-green-500 rounded-full" title="Hoạt động"></span>
                            @else
                                <span class="inline-block w-2.5 h-2.5 bg-red-500 rounded-full" title="Tắt"></span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                      class="inline" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')">
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
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-folder-open text-3xl mb-3"></i>
                                <p class="text-sm">Chưa có danh mục nào</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
