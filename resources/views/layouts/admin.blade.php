<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - SOICAU7777</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Lexend', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-100 antialiased">
    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Topbar --}}
            @include('admin.partials.topbar')

            {{-- Content --}}
            <main class="flex-1 overflow-y-auto p-6">
                @include('admin.partials.alerts')
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Simple toggle for mobile sidebar
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        }
    </script>
    @yield('scripts')
</body>
</html>
