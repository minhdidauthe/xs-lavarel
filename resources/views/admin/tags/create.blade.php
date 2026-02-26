@extends('layouts.admin')

@section('title', 'Thêm tag')
@section('page-title', 'Thêm tag')

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Thêm tag</h2>
            <p class="text-sm text-gray-500 mt-1">Tạo tag mới cho bài viết</p>
        </div>
        <a href="{{ route('admin.tags.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">
            <i class="fas fa-arrow-left mr-1"></i>Quay lại
        </a>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.tags.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên tag <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="Nhập tên tag">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug --}}
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="Tự động tạo nếu để trống">
                    @error('slug')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Submit --}}
            <div class="mt-8 flex items-center gap-3">
                <button type="submit"
                        class="bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:shadow-lg transition">
                    <i class="fas fa-save mr-2"></i>Lưu tag
                </button>
                <a href="{{ route('admin.tags.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">Hủy</a>
            </div>
        </form>
    </div>
@endsection
