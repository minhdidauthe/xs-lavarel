<header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between flex-shrink-0">
    <div class="flex items-center gap-4">
        <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700">
            <i class="fas fa-bars text-lg"></i>
        </button>
        <h2 class="text-lg font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
    </div>

    <div class="flex items-center gap-4">
        <div class="relative" id="userDropdown">
            <button onclick="document.getElementById('userMenu').classList.toggle('hidden')"
                class="flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 transition">
                <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-orange-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="hidden sm:inline font-medium">{{ auth()->user()->name }}</span>
                <span class="hidden sm:inline px-2 py-0.5 bg-gray-100 rounded text-[10px] font-bold uppercase text-gray-500">{{ auth()->user()->role }}</span>
                <i class="fas fa-chevron-down text-xs"></i>
            </button>

            <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                <a href="/" target="_blank" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-external-link-alt mr-2"></i> Xem trang chủ
                </a>
                <hr class="my-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
