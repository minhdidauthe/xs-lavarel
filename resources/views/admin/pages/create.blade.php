@extends('layouts.admin')

@section('title', 'Thêm trang')
@section('page-title', 'Thêm trang')

@section('content')
    <form action="{{ route('admin.pages.store') }}" method="POST">
        @csrf

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Thêm trang</h2>
                <p class="text-sm text-gray-500 mt-1">Tạo trang mới</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.pages.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">
                    <i class="fas fa-arrow-left mr-1"></i>Quay lại
                </a>
                <button type="submit"
                        class="bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:shadow-lg transition">
                    <i class="fas fa-save mr-2"></i>Lưu trang
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column - Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Title --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Tiêu đề <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="Nhập tiêu đề trang">
                    @error('title')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Content --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <label for="page-content" class="block text-sm font-medium text-gray-700 mb-1">Nội dung <span class="text-red-500">*</span></label>
                    <textarea name="content" id="page-content">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Right Column - Sidebar --}}
            <div class="space-y-6">
                {{-- Publish Settings --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-800 mb-4">Xuất bản</h3>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                        <select name="status" id="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Nháp</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Đã đăng</option>
                        </select>
                    </div>

                    {{-- Template --}}
                    <div class="mb-4">
                        <label for="template" class="block text-sm font-medium text-gray-700 mb-1">Template</label>
                        <select name="template" id="template"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="default" {{ old('template') === 'default' ? 'selected' : '' }}>Default</option>
                            <option value="full-width" {{ old('template') === 'full-width' ? 'selected' : '' }}>Full Width</option>
                            <option value="sidebar" {{ old('template') === 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                        </select>
                    </div>

                    {{-- Sort Order --}}
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Thứ tự</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    </div>
                </div>

                {{-- SEO --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-800 mb-4">SEO</h3>

                    {{-- Meta Title --}}
                    <div class="mb-4">
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               placeholder="Tiêu đề SEO">
                        @error('meta_title')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Meta Description --}}
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                  placeholder="Mô tả SEO">{{ old('meta_description') }}</textarea>
                        @error('meta_description')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#page-content',
            height: 500,
            menubar: true,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image media link | shortcode | code fullscreen',
            content_style: "body { font-family: 'Lexend', sans-serif; font-size: 14px; }",
            images_upload_url: '{{ route("admin.upload.image") }}',
            images_upload_handler: function (blobInfo) {
                return new Promise(function (resolve, reject) {
                    var formData = new FormData();
                    formData.append('image', blobInfo.blob(), blobInfo.filename());

                    fetch('{{ route("admin.upload.image") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.location) {
                            resolve(result.location);
                        } else {
                            reject('Upload failed');
                        }
                    })
                    .catch(() => reject('Upload failed'));
                });
            },
            setup: function (editor) {
                editor.ui.registry.addButton('shortcode', {
                    text: 'Shortcode',
                    icon: 'code-sample',
                    onAction: function () {
                        editor.windowManager.open({
                            title: 'Chèn Shortcode',
                            body: {
                                type: 'panel',
                                items: [{
                                    type: 'input',
                                    name: 'shortcode',
                                    label: 'Shortcode',
                                    placeholder: 'vd: [kqxs region="MB"]'
                                }]
                            },
                            buttons: [
                                { type: 'cancel', text: 'Hủy' },
                                { type: 'submit', text: 'Chèn', primary: true }
                            ],
                            onSubmit: function (api) {
                                var data = api.getData();
                                editor.insertContent(data.shortcode);
                                api.close();
                            }
                        });
                    }
                });
            }
        });
    </script>
@endsection
