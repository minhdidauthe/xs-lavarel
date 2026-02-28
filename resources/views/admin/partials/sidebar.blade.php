<aside id="sidebar" class="w-64 bg-slate-900 text-white flex flex-col flex-shrink-0 transition-transform lg:translate-x-0 -translate-x-full lg:relative fixed inset-y-0 left-0 z-50">
    {{-- Logo --}}
    <div class="p-5 border-b border-white/10">
        <a href="{{ route('admin.dashboard') }}" class="block">
            <h1 class="text-xl font-black tracking-tighter">
                SOICAU<span class="text-red-500">7777</span>
            </h1>
            <p class="text-[10px] text-gray-500 uppercase tracking-widest">Admin Panel</p>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto py-4 space-y-1">
        {{-- MAIN --}}
        <p class="px-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Main</p>

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'text-white bg-white/10 border-l-4 border-red-500' : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-4 border-transparent' }} transition-colors">
            <i class="fas fa-tachometer-alt w-5 text-center"></i> Dashboard
        </a>

        {{-- CONTENT --}}
        <p class="px-4 pt-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Nội dung</p>

        <a href="{{ route('admin.posts.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.posts.*') ? 'text-white bg-white/10 border-l-4 border-red-500' : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-4 border-transparent' }} transition-colors">
            <i class="fas fa-newspaper w-5 text-center"></i> Bài viết
        </a>

        <a href="{{ route('admin.categories.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'text-white bg-white/10 border-l-4 border-red-500' : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-4 border-transparent' }} transition-colors">
            <i class="fas fa-folder w-5 text-center"></i> Danh mục
        </a>

        <a href="{{ route('admin.tags.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.tags.*') ? 'text-white bg-white/10 border-l-4 border-red-500' : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-4 border-transparent' }} transition-colors">
            <i class="fas fa-tags w-5 text-center"></i> Tags
        </a>

        <a href="{{ route('admin.pages.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.pages.*') ? 'text-white bg-white/10 border-l-4 border-red-500' : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-4 border-transparent' }} transition-colors">
            <i class="fas fa-file-alt w-5 text-center"></i> Trang
        </a>

        {{-- INTERACTIONS --}}
        <p class="px-4 pt-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Tương tác</p>

        <a href="{{ route('admin.comments.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.comments.*') ? 'text-white bg-white/10 border-l-4 border-red-500' : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-4 border-transparent' }} transition-colors">
            <i class="fas fa-comments w-5 text-center"></i> Bình luận
            @php $pendingCount = \App\Models\Comment::where('status', 'pending')->count(); @endphp
            @if($pendingCount > 0)
                <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
            @endif
        </a>

        {{-- LOTTERY --}}
        <p class="px-4 pt-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Xổ số</p>

        <a href="{{ route('admin.shortcodes.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.shortcodes.*') ? 'text-white bg-white/10 border-l-4 border-red-500' : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-4 border-transparent' }} transition-colors">
            <i class="fas fa-code w-5 text-center"></i> Shortcodes
        </a>

        <a href="{{ route('admin.menus.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.menus.*') ? 'text-white bg-white/10 border-l-4 border-red-500' : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-4 border-transparent' }} transition-colors">
            <i class="fas fa-bars w-5 text-center"></i> Menu
        </a>

        {{-- SYSTEM (admin only) --}}
        @if(auth()->user()->isAdmin())
        <p class="px-4 pt-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2">Hệ thống</p>

        <a href="{{ route('admin.users.index') }}"
           class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'text-white bg-white/10 border-l-4 border-red-500' : 'text-gray-400 hover:text-white hover:bg-white/5 border-l-4 border-transparent' }} transition-colors">
            <i class="fas fa-users w-5 text-center"></i> Người dùng
        </a>
        @endif
    </nav>

    {{-- Footer --}}
    <div class="p-4 border-t border-white/10">
        <a href="/" target="_blank" class="flex items-center gap-2 text-xs text-gray-500 hover:text-gray-300 transition">
            <i class="fas fa-external-link-alt"></i> Xem trang chủ
        </a>
    </div>
</aside>
