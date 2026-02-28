@extends('layouts.admin')

@section('title', 'Thêm menu')
@section('page-title', 'Thêm menu')

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Thêm menu</h2>
            <p class="text-sm text-gray-500 mt-1">Tạo mục menu mới</p>
        </div>
        <a href="{{ route('admin.menus.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">
            <i class="fas fa-arrow-left mr-1"></i>Quay lại
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.menus.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tên hiển thị <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="vd: Trang Chủ">
                    @error('title')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="url" class="block text-sm font-medium text-gray-700 mb-1">URL <span class="text-red-500">*</span></label>
                    <input type="text" name="url" id="url" value="{{ old('url') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 font-mono"
                           placeholder="vd: /soi-cau hoặc https://...">
                    @error('url')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Icon (Font Awesome)</label>
                    <input type="text" name="icon" id="icon" value="{{ old('icon') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 font-mono"
                           placeholder="vd: fas fa-home">
                    <p class="mt-1 text-xs text-gray-400">Class Font Awesome, vd: fas fa-home, fas fa-chart-bar</p>
                    @error('icon')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="css_class" class="block text-sm font-medium text-gray-700 mb-1">CSS Class</label>
                    <input type="text" name="css_class" id="css_class" value="{{ old('css_class') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 font-mono"
                           placeholder="vd: vip">
                    <p class="mt-1 text-xs text-gray-400">CSS class thêm vào link (vd: vip cho highlight)</p>
                    @error('css_class')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="match_pattern" class="block text-sm font-medium text-gray-700 mb-1">Pattern Active</label>
                    <input type="text" name="match_pattern" id="match_pattern" value="{{ old('match_pattern') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 font-mono"
                           placeholder="vd: lich-su* hoặc blog*">
                    <p class="mt-1 text-xs text-gray-400">Pattern để highlight menu khi đang ở trang tương ứng (dùng * cho wildcard)</p>
                    @error('match_pattern')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="target" class="block text-sm font-medium text-gray-700 mb-1">Mở trong</label>
                    <select name="target" id="target"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="_self" {{ old('target') === '_self' ? 'selected' : '' }}>Cùng tab (_self)</option>
                        <option value="_blank" {{ old('target') === '_blank' ? 'selected' : '' }}>Tab mới (_blank)</option>
                    </select>
                </div>

                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Menu cha</label>
                    <select name="parent_id" id="parent_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">— Không (menu gốc) —</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Thứ tự</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>
            </div>

            <div class="mt-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}
                           class="w-4 h-4 text-red-500 border-gray-300 rounded focus:ring-red-500">
                    <span class="text-sm font-medium text-gray-700">Kích hoạt</span>
                </label>
            </div>

            <div class="mt-8 flex items-center gap-3">
                <button type="submit"
                        class="bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:shadow-lg transition">
                    <i class="fas fa-save mr-2"></i>Lưu menu
                </button>
                <a href="{{ route('admin.menus.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">Hủy</a>
            </div>
        </form>
    </div>
@endsection
