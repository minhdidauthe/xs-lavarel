<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<script>(function(){var t=localStorage.getItem('theme')||'dark';document.documentElement.setAttribute('data-theme',t)})()</script>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SOICAU7777.CLICK - Xổ Số 3 Miền')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/css/light-theme.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Lexend', sans-serif; }
        .glass-nav { background: rgba(10, 10, 11, 0.9); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.08); }
        .glass-card { background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.05); transition: all 0.3s ease; }
        .gradient-brand { background: linear-gradient(135deg, #FF3D3D 0%, #FF8A00 100%); }
        .text-gradient { background: linear-gradient(135deg, #FF3D3D 0%, #FF8A00 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .nav-link { position: relative; padding: 0.5rem 1rem; transition: color 0.3s; }
        .nav-link:hover { color: #FF3D3D; }
        .ball { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: 800; font-size: 1rem; position: relative; overflow: hidden; }
        .ball-red { background: radial-gradient(circle at 30% 30%, #ff5f5f, #C30000); color: white; }
        .ball-gold { background: radial-gradient(circle at 30% 30%, #ffd700, #b8860b); color: #222; }
        
        /* Mobile Menu Animation */
        #mobile-menu { transition: all 0.3s ease-in-out; transform: translateY(-100%); opacity: 0; pointer-events: none; }
        #mobile-menu.active { transform: translateY(0); opacity: 1; pointer-events: auto; }
    </style>
    @yield('styles')
</head>
<body class="bg-[#050505] text-gray-200 antialiased">
    <nav class="glass-nav sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-2 group cursor-pointer">
                    <div class="w-10 h-10 gradient-brand rounded-xl flex items-center justify-center shadow-lg shadow-red-600/30 group-hover:rotate-12 transition-transform">
                        <i class="fas fa-dice text-white text-xl"></i>
                    </div>
                    <span class="text-xl font-black tracking-tighter text-white uppercase">SOI<span class="text-red-500">CAU</span>7777</span>
                </a>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-2">
                    <a href="/" class="nav-link font-bold {{ request()->is('/') ? 'text-red-500' : '' }} text-xs uppercase">TRANG CHỦ</a>
                    <a href="/lich-su/north" class="nav-link font-semibold {{ request()->is('lich-su*') ? 'text-red-500' : '' }} text-xs uppercase">LỊCH SỬ</a>
                    <a href="/thong-ke" class="nav-link font-semibold {{ request()->is('thong-ke*') ? 'text-red-500' : '' }} text-xs uppercase">THỐNG KÊ</a>
                    <a href="/soi-cau" class="nav-link font-semibold {{ request()->is('soi-cau*') ? 'text-red-500' : '' }} text-xs uppercase">SOI CẦU</a>
                    <a href="/quay-thu" class="nav-link font-semibold {{ request()->is('quay-thu*') ? 'text-red-500' : '' }} text-xs uppercase"><i class="fas fa-dice mr-1"></i> QUAY THỬ</a>
                    <a href="/blog" class="nav-link font-semibold {{ request()->is('blog*') ? 'text-red-500' : '' }} text-xs uppercase"><i class="fas fa-newspaper mr-1"></i> BLOG</a>
                    <a href="#" class="nav-link font-semibold text-yellow-500 text-xs uppercase"><i class="fas fa-crown mr-1"></i> VIP</a>
                </div>

                <!-- Right Side Tools -->
                <div class="flex items-center gap-2">
                    <button id="theme-toggle" onclick="toggleTheme()" class="w-10 h-10 flex items-center justify-center text-white text-lg focus:outline-none hover:text-yellow-400 transition" title="Chuyển theme">
                        <i class="fas fa-sun"></i>
                    </button>
                    <button class="hidden sm:block bg-white/5 text-white px-5 py-2 rounded-full text-xs font-bold transition border border-white/10 uppercase">Login</button>
                    <!-- Mobile Toggle Button -->
                    <button id="menu-toggle" class="md:hidden w-10 h-10 flex items-center justify-center text-white text-xl focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div id="mobile-menu" class="fixed inset-x-0 top-20 border-b border-white/10 md:hidden z-40" style="background: var(--bg-mobile-menu, #0A0A0B)">
            <div class="px-4 pt-2 pb-6 space-y-1 shadow-2xl">
                <a href="/" class="block px-4 py-4 text-sm font-bold {{ request()->is('/') ? 'text-red-500 bg-red-500/5' : 'text-gray-300' }} rounded-xl uppercase">
                    <i class="fas fa-home w-6"></i> Trang Chủ
                </a>
                <a href="/lich-su/north" class="block px-4 py-4 text-sm font-bold {{ request()->is('lich-su*') ? 'text-red-500 bg-red-500/5' : 'text-gray-300' }} rounded-xl uppercase">
                    <i class="fas fa-history w-6"></i> Lịch Sử KQXS
                </a>
                <a href="/thong-ke" class="block px-4 py-4 text-sm font-bold {{ request()->is('thong-ke*') ? 'text-red-500 bg-red-500/5' : 'text-gray-300' }} rounded-xl uppercase">
                    <i class="fas fa-chart-bar w-6"></i> Thống Kê
                </a>
                <a href="/soi-cau" class="block px-4 py-4 text-sm font-bold {{ request()->is('soi-cau*') ? 'text-red-500 bg-red-500/5' : 'text-gray-300' }} rounded-xl uppercase">
                    <i class="fas fa-robot w-6"></i> Soi Cầu AI
                </a>
                <a href="/quay-thu" class="block px-4 py-4 text-sm font-bold {{ request()->is('quay-thu*') ? 'text-red-500 bg-red-500/5' : 'text-gray-300' }} rounded-xl uppercase">
                    <i class="fas fa-dice w-6"></i> Quay Thử XSO
                </a>
                <a href="/blog" class="block px-4 py-4 text-sm font-bold {{ request()->is('blog*') ? 'text-red-500 bg-red-500/5' : 'text-gray-300' }} rounded-xl uppercase">
                    <i class="fas fa-newspaper w-6"></i> Blog
                </a>
                <div class="pt-4 px-4">
                    <button class="w-full gradient-brand text-white py-4 rounded-2xl font-black text-sm uppercase shadow-lg shadow-red-600/20">THAM GIA NGAY 🧧</button>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="mt-20 border-t border-white/5 py-10 bg-black/80">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-600 text-[10px] uppercase font-bold tracking-widest italic">
            © 2026 SOICAU7777.CLICK - Hệ thống phân tích xổ số tự động
        </div>
    </footer>

    <script>
        // Mobile Menu Logic
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = menuToggle.querySelector('i');

        menuToggle.addEventListener('click', () => {
            const isActive = mobileMenu.classList.toggle('active');
            if (isActive) {
                menuIcon.classList.replace('fa-bars', 'fa-times');
                document.body.style.overflow = 'hidden'; // Ngăn cuộn trang khi mở menu
            } else {
                menuIcon.classList.replace('fa-times', 'fa-bars');
                document.body.style.overflow = '';
            }
        });

        // Đóng menu khi bấm vào link
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                menuIcon.classList.replace('fa-times', 'fa-bars');
                document.body.style.overflow = '';
            });
        });

        // Theme Toggle
        function updateThemeIcon(theme) {
            const btn = document.getElementById('theme-toggle');
            if (!btn) return;
            const icon = btn.querySelector('i');
            if (theme === 'light') {
                icon.className = 'fas fa-moon';
            } else {
                icon.className = 'fas fa-sun';
            }
        }

        function toggleTheme() {
            const current = document.documentElement.getAttribute('data-theme') || 'dark';
            const next = current === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            updateThemeIcon(next);
        }

        // Set icon on page load
        updateThemeIcon(document.documentElement.getAttribute('data-theme') || 'dark');
    </script>
    @yield('scripts')
</body>
</html>
