@extends('layouts.admin')

@section('title', 'Trang')
@section('page-title', 'Trang')

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Trang</h2>
            <p class="text-sm text-gray-500 mt-1">Quản lý các trang tĩnh</p>
        </div>
        <a href="{{ route('admin.pages.create') }}"
           class="bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:shadow-lg transition">
            <i class="fas fa-plus mr-2"></i>Thêm trang
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tiêu đề</th>
                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Template</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Tác giả</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Cập nhật</th>
                    <th class="text-right px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($pages as $page)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.pages.edit', $page) }}" class="text-sm font-medium text-gray-800 hover:text-red-500">
                                {{ $page->title }}
                            </a>
                            <p class="text-xs text-gray-400 mt-0.5">/page/{{ $page->slug }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($page->status === 'published')
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-green-100 text-green-700">Đã đăng</span>
                            @else
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-gray-100 text-gray-500">Nháp</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs text-gray-500 capitalize">{{ $page->template ?? 'default' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">{{ $page->author->name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-gray-400">{{ $page->updated_at->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.pages.edit', $page) }}"
                                   class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST"
                                      class="inline" onclick="return confirm('Bạn có chắc muốn xóa trang này?')">
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
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-file-alt text-3xl mb-3"></i>
                                <p class="text-sm">Chưa có trang nào</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($pages->hasPages())
        <div class="mt-6">
            {{ $pages->links() }}
        </div>
    @endif
@endsection
