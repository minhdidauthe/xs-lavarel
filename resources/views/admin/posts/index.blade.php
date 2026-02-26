@extends('layouts.admin')

@section('title', 'Bài viết')
@section('page-title', 'Quản lý bài viết')

@section('content')
    {{-- Top Bar --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Quản lý bài viết</h2>
        <a href="{{ route('admin.posts.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-semibold rounded-lg shadow hover:from-red-600 hover:to-red-700 transition">
            <i class="fas fa-plus text-xs"></i>
            Thêm bài viết
        </a>
    </div>

    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('admin.posts.index') }}" class="flex flex-wrap items-end gap-4">
            {{-- Status --}}
            <div class="flex-1 min-w-[160px]">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                <select name="status" id="status"
                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                    <option value="">Tất cả</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Nháp</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Đã đăng</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Lưu trữ</option>
                </select>
            </div>

            {{-- Category --}}
            <div class="flex-1 min-w-[160px]">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                <select name="category" id="category"
                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                    <option value="">Tất cả danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Search --}}
            <div class="flex-1 min-w-[200px]">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Tìm kiếm</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       placeholder="Tìm theo tiêu đề..."
                       class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
            </div>

            {{-- Filter Button --}}
            <div>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-800 text-white text-sm font-semibold rounded-lg hover:bg-gray-900 transition">
                    <i class="fas fa-filter text-xs"></i>
                    Lọc
                </button>
            </div>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Tiêu đề</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Tác giả</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Danh mục</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Lượt xem</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Ngày tạo</th>
                        <th class="px-6 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($posts as $post)
                        <tr class="hover:bg-gray-50 transition">
                            {{-- Title --}}
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.posts.edit', $post) }}"
                                   class="font-medium text-gray-800 hover:text-red-500 transition truncate block max-w-[280px]"
                                   title="{{ $post->title }}">
                                    {{ Str::limit($post->title, 50) }}
                                </a>
                            </td>

                            {{-- Author --}}
                            <td class="px-6 py-4 text-gray-600">
                                {{ $post->author->name ?? 'N/A' }}
                            </td>

                            {{-- Category --}}
                            <td class="px-6 py-4">
                                @if($post->category)
                                    <span class="inline-block px-2.5 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700">
                                        {{ $post->category->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">--</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @switch($post->status)
                                    @case('published')
                                        <span class="inline-block px-2.5 py-1 text-xs font-bold uppercase rounded-full bg-green-100 text-green-700">
                                            Đã đăng
                                        </span>
                                        @break
                                    @case('draft')
                                        <span class="inline-block px-2.5 py-1 text-xs font-bold uppercase rounded-full bg-gray-100 text-gray-500">
                                            Nháp
                                        </span>
                                        @break
                                    @case('scheduled')
                                        <span class="inline-block px-2.5 py-1 text-xs font-bold uppercase rounded-full bg-blue-100 text-blue-700">
                                            Lên lịch
                                        </span>
                                        @break
                                    @case('archived')
                                        <span class="inline-block px-2.5 py-1 text-xs font-bold uppercase rounded-full bg-red-100 text-red-700">
                                            Lưu trữ
                                        </span>
                                        @break
                                    @default
                                        <span class="inline-block px-2.5 py-1 text-xs font-bold uppercase rounded-full bg-gray-100 text-gray-500">
                                            {{ $post->status }}
                                        </span>
                                @endswitch
                            </td>

                            {{-- Views --}}
                            <td class="px-6 py-4 text-gray-600">
                                {{ number_format($post->views ?? 0) }}
                            </td>

                            {{-- Date --}}
                            <td class="px-6 py-4 text-gray-500 text-xs">
                                {{ $post->created_at->format('d/m/Y H:i') }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.posts.edit', $post) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition"
                                       title="Sửa">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition"
                                                title="Xóa">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fas fa-newspaper text-4xl text-gray-300"></i>
                                    <p class="text-gray-400 text-sm">Chưa có bài viết nào</p>
                                    <a href="{{ route('admin.posts.create') }}" class="text-red-500 text-sm font-semibold hover:text-red-700">
                                        + Thêm bài viết mới
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection
