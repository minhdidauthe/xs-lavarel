<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SOICAU7777.CLICK - Xổ Số 3 Miền')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="/css/light-theme.css?v={{ filemtime(public_path('css/light-theme.css')) }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
        tailwind.config = {
            corePlugins: { preflight: false, container: false }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('styles')
</head>
<body>
    {{-- ====== TOP BAR ====== --}}
    <div class="sc-topbar">
        <div class="container">
            <span><i class="fas fa-calendar-alt"></i> {{ now()->timezone('Asia/Ho_Chi_Minh')->locale('vi')->isoFormat('dddd, D/M/Y') }}</span>
            <span><i class="fas fa-phone"></i> Hotline: 0888.777.777</span>
        </div>
    </div>

    {{-- ====== HEADER ====== --}}
    <header class="sc-header">
        <div class="container">
            <a href="/" class="sc-logo">
                <div class="sc-logo-icon">
                    <i class="fas fa-dice"></i>
                </div>
                <div class="sc-logo-text">
                    <span class="sc-logo-brand">SOI<span>CAU</span>7777</span>
                    <span class="sc-logo-slogan">Soi cầu lô đề miễn phí</span>
                </div>
            </a>
            <button id="menu-toggle" class="sc-menu-toggle" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    {{-- ====== NAVIGATION ====== --}}
    <nav class="sc-nav">
        <div class="container">
            @php
                $navMenus = \App\Models\Menu::active()->topLevel()->with('children')->orderBy('sort_order')->get();
            @endphp
            <ul class="sc-nav-list" id="nav-list">
                @forelse($navMenus as $menuItem)
                    <li>
                        <a href="{{ $menuItem->url }}"
                           class="{{ $menuItem->css_class ?? '' }} {{ $menuItem->isActive() ? 'active' : '' }}"
                           target="{{ $menuItem->target }}">
                            @if($menuItem->icon)<i class="{{ $menuItem->icon }}"></i> @endif
                            {{ $menuItem->title }}
                        </a>
                    </li>
                @empty
                    {{-- Fallback hardcoded menu if DB is empty --}}
                    <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}"><i class="fas fa-home"></i> Trang Chủ</a></li>
                    <li><a href="/lich-su/north" class="{{ request()->is('lich-su*') ? 'active' : '' }}"><i class="fas fa-history"></i> Lịch Sử KQ</a></li>
                    <li><a href="/soi-cau" class="{{ request()->is('soi-cau*') ? 'active' : '' }}"><i class="fas fa-robot"></i> Soi Cầu</a></li>
                    <li><a href="/thong-ke" class="{{ request()->is('thong-ke*') ? 'active' : '' }}"><i class="fas fa-chart-bar"></i> Thống Kê</a></li>
                    <li><a href="/quay-thu" class="{{ request()->is('quay-thu*') ? 'active' : '' }}"><i class="fas fa-dice"></i> Quay Thử</a></li>
                    <li><a href="/blog" class="{{ request()->is('blog*') ? 'active' : '' }}"><i class="fas fa-newspaper"></i> Blog</a></li>
                    <li><a href="#" class="vip"><i class="fas fa-crown"></i> VIP</a></li>
                @endforelse
            </ul>
        </div>
    </nav>

    {{-- ====== MAIN CONTENT ====== --}}
    <main class="sc-main">
        @yield('content')
    </main>

    {{-- ====== FOOTER ====== --}}
    <footer class="sc-footer">
        <div class="container">
            <div class="sc-footer-grid">
                <div class="sc-footer-col">
                    <h4>SOICAU7777.CLICK</h4>
                    <p>Trang soi cầu lô đề miễn phí chính xác nhất. Cập nhật kết quả xổ số 3 miền hàng ngày, phân tích thống kê AI thông minh.</p>
                </div>
                <div class="sc-footer-col">
                    <h4>Liên Kết Nhanh</h4>
                    <ul>
                        <li><a href="/"><i class="fas fa-angle-right"></i> Trang chủ</a></li>
                        <li><a href="/soi-cau"><i class="fas fa-angle-right"></i> Soi cầu</a></li>
                        <li><a href="/thong-ke"><i class="fas fa-angle-right"></i> Thống kê</a></li>
                        <li><a href="/blog"><i class="fas fa-angle-right"></i> Blog</a></li>
                    </ul>
                </div>
                <div class="sc-footer-col">
                    <h4>Kết Quả Xổ Số</h4>
                    <ul>
                        <li><a href="/lich-su/north"><i class="fas fa-angle-right"></i> XSMB</a></li>
                        <li><a href="/lich-su/central"><i class="fas fa-angle-right"></i> XSMT</a></li>
                        <li><a href="/lich-su/south"><i class="fas fa-angle-right"></i> XSMN</a></li>
                        <li><a href="/quay-thu"><i class="fas fa-angle-right"></i> Quay thử</a></li>
                    </ul>
                </div>
                <div class="sc-footer-col">
                    <h4>Thông Tin</h4>
                    <p>Kết quả xổ số được cập nhật trực tiếp từ các công ty xổ số kiến thiết 3 miền.</p>
                    <div class="sc-footer-social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-telegram-plane"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="sc-footer-bottom">
                &copy; 2026 SOICAU7777.CLICK - Hệ thống phân tích xổ số tự động. Mọi thông tin chỉ mang tính tham khảo.
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Logic
        const menuToggle = document.getElementById('menu-toggle');
        const navList = document.getElementById('nav-list');

        menuToggle.addEventListener('click', () => {
            const isActive = navList.classList.toggle('active');
            const icon = menuToggle.querySelector('i');
            if (isActive) {
                icon.classList.replace('fa-bars', 'fa-times');
            } else {
                icon.classList.replace('fa-times', 'fa-bars');
            }
        });

        // Close menu on link click
        document.querySelectorAll('.sc-nav-list a').forEach(link => {
            link.addEventListener('click', () => {
                navList.classList.remove('active');
                menuToggle.querySelector('i').classList.replace('fa-times', 'fa-bars');
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
