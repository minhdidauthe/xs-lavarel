@extends('layouts.admin')

@section('title', 'Sửa shortcode')
@section('page-title', 'Sửa shortcode')

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Sửa shortcode</h2>
            <p class="text-sm text-gray-500 mt-1">
                Chỉnh sửa shortcode: <strong>{{ $shortcode->name }}</strong>
                @if($shortcode->is_builtin)
                    <span class="ml-2 px-2 py-0.5 text-[10px] font-bold uppercase rounded-full bg-blue-100 text-blue-700">Hệ thống</span>
                @endif
            </p>
        </div>
        <a href="{{ route('admin.shortcodes.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">
            <i class="fas fa-arrow-left mr-1"></i>Quay lại
        </a>
    </div>

    {{-- Built-in notice --}}
    @if($shortcode->is_builtin)
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-start gap-3">
            <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
            <div>
                <p class="text-sm font-medium text-blue-800">Đây là shortcode hệ thống</p>
                <p class="text-xs text-blue-600 mt-1">Nội dung được render bởi hệ thống. Bạn có thể sửa tên, mô tả và bật/tắt shortcode này.</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Form --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.shortcodes.update', $shortcode) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên shortcode <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $shortcode->name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="Nhập tên shortcode">
                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Code --}}
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Code <span class="text-red-500">*</span></label>
                    <input type="text" name="code" id="code" value="{{ old('code', $shortcode->code) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg font-mono {{ $shortcode->is_builtin ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : 'focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500' }}"
                           placeholder="vd: my_shortcode"
                           pattern="^[a-z_][a-z0-9_]*$"
                           {{ $shortcode->is_builtin ? 'readonly' : 'required' }}>
                    @if($shortcode->is_builtin)
                        <p class="mt-1 text-xs text-gray-400">Code của shortcode hệ thống không thể thay đổi</p>
                    @else
                        <p class="mt-1 text-xs text-gray-400">Chỉ dùng chữ thường và dấu gạch dưới (vd: ten_shortcode)</p>
                    @endif
                    @error('code')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Content (only for custom shortcodes) --}}
            @if(!$shortcode->is_builtin)
            <div class="mt-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Nội dung HTML <span class="text-red-500">*</span></label>
                <textarea name="content" id="content" rows="10"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 font-mono text-sm"
                          placeholder="Nhập nội dung HTML cho shortcode">{{ old('content', $shortcode->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            @endif

            {{-- Description --}}
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                          placeholder="Mô tả ngắn về shortcode">{{ old('description', $shortcode->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Is Active --}}
            <div class="mt-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $shortcode->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-red-500 border-gray-300 rounded focus:ring-red-500">
                    <span class="text-sm font-medium text-gray-700">Kích hoạt</span>
                </label>
                @if($shortcode->is_builtin)
                    <p class="mt-1 text-xs text-gray-400 ml-7">Tắt shortcode này sẽ ẩn nó khỏi tất cả các trang sử dụng</p>
                @endif
            </div>

            {{-- Submit --}}
            <div class="mt-8 flex items-center gap-3">
                <button type="submit"
                        class="bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:shadow-lg transition">
                    <i class="fas fa-save mr-2"></i>Cập nhật shortcode
                </button>
                <a href="{{ route('admin.shortcodes.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">Hủy</a>
            </div>
        </form>
    </div>
@endsection
