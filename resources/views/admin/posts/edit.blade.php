@extends('layouts.admin')

@section('title', 'Sửa bài viết')
@section('page-title', 'Sửa bài viết')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Sửa bài viết</h2>
        <a href="{{ route('admin.posts.index') }}"
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition">
            <i class="fas fa-arrow-left text-xs"></i>
            Quay lại danh sách
        </a>
    </div>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Title --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Tiêu đề <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
                           placeholder="Nhập tiêu đề bài viết..."
                           class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Content --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Nội dung <span class="text-red-500">*</span></label>
                    <textarea name="content" id="content" rows="20">{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Excerpt --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Mô tả ngắn</label>
                    <textarea name="excerpt" id="excerpt" rows="3"
                              placeholder="Nhập mô tả ngắn cho bài viết..."
                              class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">{{ old('excerpt', $post->excerpt) }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Right Column --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Publish Settings --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100">Cài đặt đăng bài</h3>

                    {{-- Status --}}
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái</label>
                        <select name="status" id="status"
                                class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                            <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Nháp</option>
                            <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Đã đăng</option>
                            <option value="scheduled" {{ old('status', $post->status) === 'scheduled' ? 'selected' : '' }}>Lên lịch</option>
                            <option value="archived" {{ old('status', $post->status) === 'archived' ? 'selected' : '' }}>Lưu trữ</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Published At --}}
                    <div class="mb-4">
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Ngày đăng</label>
                        <input type="datetime-local" name="published_at" id="published_at"
                               value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                               class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                        @error('published_at')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                        <select name="category_id" id="category_id"
                                class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tags --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                        <div class="max-h-40 overflow-y-auto space-y-2 border border-gray-200 rounded-lg p-3">
                            @foreach($tags as $tag)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                           {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-red-500 focus:ring-red-500">
                                    <span class="text-sm text-gray-600">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('tags')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Is Featured --}}
                    <div class="mb-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_featured" value="1"
                                   {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-red-500 focus:ring-red-500">
                            <span class="text-sm font-medium text-gray-700">Bài viết nổi bật</span>
                        </label>
                        @error('is_featured')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Featured Image --}}
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-sm font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100">Ảnh đại diện</h3>

                    {{-- Current Image Preview --}}
                    @if($post->featured_image)
                        <div class="mb-4">
                            <p class="text-xs text-gray-500 mb-2">Ảnh hiện tại:</p>
                            <div class="relative rounded-lg overflow-hidden border border-gray-200">
                                <img src="{{ asset('storage/' . $post->featured_image) }}"
                                     alt="{{ $post->title }}"
                                     class="w-full h-40 object-cover">
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="featured_image" class="block text-xs text-gray-500 mb-2">
                            {{ $post->featured_image ? 'Chọn ảnh mới để thay thế:' : 'Chọn ảnh:' }}
                        </label>
                        <input type="file" name="featured_image" id="featured_image" accept="image/*"
                               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-600 hover:file:bg-red-100 cursor-pointer">
                    </div>
                    @error('featured_image')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SEO Settings --}}
                <div class="bg-white rounded-xl shadow-sm" x-data="{ open: false }">
                    <button type="button" @click="open = !open"
                            class="w-full flex items-center justify-between p-6 text-left">
                        <h3 class="text-sm font-bold text-gray-800">Cài đặt SEO</h3>
                        <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-6 pb-6 space-y-4">
                        {{-- Meta Title --}}
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $post->meta_title) }}"
                                   placeholder="Tiêu đề SEO..."
                                   class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                            @error('meta_title')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Meta Description --}}
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="3"
                                      placeholder="Mô tả SEO..."
                                      class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">{{ old('meta_description', $post->meta_description) }}</textarea>
                            @error('meta_description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Meta Keywords --}}
                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $post->meta_keywords) }}"
                                   placeholder="Từ khóa SEO, cách nhau bởi dấu phẩy..."
                                   class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                            @error('meta_keywords')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div>
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-bold rounded-xl shadow hover:from-red-600 hover:to-red-700 transition">
                        <i class="fas fa-save"></i>
                        Cập nhật
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            height: 500,
            menubar: true,
            plugins: 'image link media table code fullscreen lists wordcount',
            toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | code fullscreen | shortcodes',
            content_style: 'body { font-family: "Lexend", sans-serif; font-size: 14px; }',
            images_upload_url: '{{ route("admin.upload.image") }}',
            images_upload_handler: function (blobInfo, progress) {
                return new Promise(function (resolve, reject) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '{{ route("admin.upload.image") }}');
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                    xhr.upload.onprogress = function (e) {
                        progress(e.loaded / e.total * 100);
                    };

                    xhr.onload = function () {
                        if (xhr.status !== 200) {
                            reject({ message: 'Upload failed: ' + xhr.status, remove: true });
                            return;
                        }
                        var json = JSON.parse(xhr.responseText);
                        if (!json || typeof json.location !== 'string') {
                            reject('Invalid response from server.');
                            return;
                        }
                        resolve(json.location);
                    };

                    xhr.onerror = function () {
                        reject({ message: 'Upload failed due to network error.', remove: true });
                    };

                    var formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                });
            },
            setup: function (editor) {
                // Custom Shortcodes menu button
                editor.ui.registry.addMenuButton('shortcodes', {
                    text: 'Shortcodes',
                    fetch: function (callback) {
                        var items = [
                            {
                                type: 'menuitem',
                                text: 'KQXS Miền Bắc',
                                onAction: function () {
                                    editor.insertContent('[kqxs region="MB"]');
                                }
                            },
                            {
                                type: 'menuitem',
                                text: 'KQXS Miền Nam',
                                onAction: function () {
                                    editor.insertContent('[kqxs region="MN"]');
                                }
                            },
                            {
                                type: 'menuitem',
                                text: 'KQXS Miền Trung',
                                onAction: function () {
                                    editor.insertContent('[kqxs region="MT"]');
                                }
                            },
                            {
                                type: 'menuitem',
                                text: 'Soi Cầu AI',
                                onAction: function () {
                                    editor.insertContent('[soi_cau]');
                                }
                            },
                            {
                                type: 'menuitem',
                                text: 'Thống Kê',
                                onAction: function () {
                                    editor.insertContent('[thong_ke days="30"]');
                                }
                            },
                            {
                                type: 'menuitem',
                                text: 'Lô Gan',
                                onAction: function () {
                                    editor.insertContent('[lo_gan limit="10"]');
                                }
                            }
                        ];
                        callback(items);
                    }
                });
            }
        });
    </script>
@endsection
