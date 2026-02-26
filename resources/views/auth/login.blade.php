<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng Nhập - SOICAU7777 Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Lexend', sans-serif; }
    </style>
</head>
<body class="bg-[#050505] min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="/" class="inline-block">
                <h1 class="text-3xl font-black text-white tracking-tighter">
                    SOICAU<span class="bg-gradient-to-r from-red-500 to-orange-500 bg-clip-text text-transparent">7777</span>
                </h1>
            </a>
            <p class="text-gray-500 text-xs uppercase tracking-widest mt-2">Admin Panel</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl p-8">
            <h2 class="text-xl font-bold text-white mb-6">Đăng Nhập</h2>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-500/10 border border-red-500/20 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-400 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Mật khẩu</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-600 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition">
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-white/20 bg-white/5 text-red-500 focus:ring-red-500">
                        <span class="text-sm text-gray-400">Ghi nhớ</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full py-3 bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold rounded-lg hover:opacity-90 transition uppercase tracking-wider text-sm">
                    Đăng Nhập
                </button>
            </form>
        </div>

        <p class="text-center text-gray-600 text-xs mt-6">
            <a href="/" class="hover:text-gray-400 transition">&larr; Quay về trang chủ</a>
        </p>
    </div>
</body>
</html>
