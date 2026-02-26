@extends('layouts.app')

@section('title', 'SOICAU7777.CLICK - Kết Quả Xổ Số 3 Miền Hôm Nay')

@section('content')
    {{-- Hero --}}
    <div class="relative py-10 overflow-hidden border-b border-white/5 bg-gradient-to-b from-red-950/20 to-transparent">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-3 tracking-tight">
                KẾT QUẢ XỔ SỐ <span class="text-gradient">Hôm Nay</span>
            </h1>
            <p class="text-gray-400 text-sm">Cập nhật trực tiếp · nhanh · chính xác</p>
            <div class="mt-6 flex flex-wrap justify-center gap-3 text-xs">
                <div class="glass-card px-5 py-2 rounded-full flex items-center gap-2">
                    <i class="fas fa-bolt text-yellow-400"></i>
                    <span class="text-gray-400">Cập nhật: <strong class="text-white">{{ now()->timezone('Asia/Ho_Chi_Minh')->format('H:i:s') }}</strong></span>
                </div>
                <div class="glass-card px-5 py-2 rounded-full flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                    <span class="text-gray-400">Máy chủ: <strong class="text-green-400">TRỰC TUYẾN</strong></span>
                </div>
            </div>
        </div>
    </div>

    <main class="max-w-7xl mx-auto px-4 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- ══ LEFT: Results ══ --}}
            <div class="lg:col-span-8 space-y-8">

                {{-- ── MIỀN BẮC ── --}}
                <section class="glass-card rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
                    <div class="p-5 gradient-brand flex justify-between items-center">
                        <div class="flex items-center gap-3 text-white">
                            <i class="fas fa-trophy text-xl text-yellow-300"></i>
                            <div>
                                <h2 class="text-lg font-extrabold uppercase tracking-tight">Xổ Số Miền Bắc</h2>
                                <p class="text-[10px] opacity-75 uppercase font-semibold">Trực tiếp lúc 18:15 hàng ngày</p>
                            </div>
                        </div>
                        <span class="text-white font-black italic text-base">{{ $lotteryMB['date'] ?? now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}</span>
                    </div>

                    @if($lotteryMB && isset($lotteryMB['prizes']))
                    <div class="bg-[#0C0C0D]">
                        <table class="w-full text-center border-collapse text-sm">
                            <tbody>
                                {{-- ĐB --}}
                                <tr class="border-b border-white/5 bg-red-500/5">
                                    <td class="py-5 px-4 w-28 font-bold text-red-400 text-xs border-r border-white/5 uppercase">Đặc Biệt</td>
                                    <td class="py-5 px-4">
                                        @php
                                            $sp = $lotteryMB['prizes']['special'] ?? ['-----'];
                                            $spStr = is_array($sp) ? ($sp[0] ?? '-----') : $sp;
                                        @endphp
                                        <div class="flex justify-center gap-2">
                                            @foreach(str_split($spStr) as $digit)
                                                <span class="ball ball-red text-xl">{{ $digit }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                {{-- G1 --}}
                                <tr class="border-b border-white/5">
                                    <td class="py-3 px-4 font-bold text-gray-500 text-[10px] border-r border-white/5 uppercase tracking-widest">Giải Nhất</td>
                                    <td class="py-3 px-4 text-xl font-black text-white tracking-[0.25em]">
                                        {{ is_array($lotteryMB['prizes']['first'] ?? null) ? ($lotteryMB['prizes']['first'][0] ?? '-----') : ($lotteryMB['prizes']['first'] ?? '-----') }}
                                    </td>
                                </tr>
                                {{-- G2 --}}
                                <tr class="border-b border-white/5 bg-white/[0.015]">
                                    <td class="py-3 px-4 font-bold text-gray-500 text-[10px] border-r border-white/5 uppercase tracking-widest">Giải Nhì</td>
                                    <td class="py-3 px-4 text-lg font-bold text-gray-200 tracking-[0.2em]">
                                        {{ implode('  ·  ', array_map(fn($v) => is_array($v)?$v[0]:$v, (array)($lotteryMB['prizes']['second'] ?? ['-----','-----']))) }}
                                    </td>
                                </tr>
                                {{-- G3 --}}
                                <tr class="border-b border-white/5">
                                    <td class="py-3 px-4 font-bold text-gray-500 text-[10px] border-r border-white/5 uppercase tracking-widest">Giải Ba</td>
                                    <td class="py-3 px-4">
                                        <div class="grid grid-cols-3 md:grid-cols-6 gap-2 text-base font-bold text-gray-300 tracking-wider">
                                            @foreach((array)($lotteryMB['prizes']['third'] ?? []) as $p)
                                                <span>{{ is_array($p)?$p[0]:$p }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                {{-- G4 --}}
                                <tr class="border-b border-white/5 bg-white/[0.015]">
                                    <td class="py-3 px-4 font-bold text-gray-500 text-[10px] border-r border-white/5 uppercase tracking-widest">Giải Tư</td>
                                    <td class="py-3 px-4">
                                        <div class="grid grid-cols-4 gap-2 text-sm font-bold text-gray-400 tracking-wider">
                                            @foreach((array)($lotteryMB['prizes']['fourth'] ?? []) as $p)
                                                <span>{{ is_array($p)?$p[0]:$p }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                {{-- G5 --}}
                                <tr class="border-b border-white/5">
                                    <td class="py-3 px-4 font-bold text-gray-500 text-[10px] border-r border-white/5 uppercase tracking-widest">Giải Năm</td>
                                    <td class="py-3 px-4">
                                        <div class="grid grid-cols-3 md:grid-cols-6 gap-2 text-base font-bold text-gray-300 tracking-wider">
                                            @foreach((array)($lotteryMB['prizes']['fifth'] ?? []) as $p)
                                                <span>{{ is_array($p)?$p[0]:$p }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                {{-- G6 --}}
                                <tr class="border-b border-white/5 bg-white/[0.015]">
                                    <td class="py-3 px-4 font-bold text-gray-500 text-[10px] border-r border-white/5 uppercase tracking-widest">Giải Sáu</td>
                                    <td class="py-3 px-4">
                                        <div class="flex justify-around text-xl font-black text-white tracking-widest">
                                            @foreach((array)($lotteryMB['prizes']['sixth'] ?? []) as $p)
                                                <span>{{ is_array($p)?$p[0]:$p }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                {{-- G7 --}}
                                <tr>
                                    <td class="py-3 px-4 font-bold text-gray-500 text-[10px] border-r border-white/5 uppercase tracking-widest">Giải Bảy</td>
                                    <td class="py-3 px-4">
                                        <div class="flex justify-around text-xl font-black text-red-400 tracking-widest">
                                            @foreach((array)($lotteryMB['prizes']['seventh'] ?? []) as $p)
                                                <span>{{ is_array($p)?$p[0]:$p }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-16 text-gray-500 bg-[#0C0C0D]">
                        <i class="fas fa-sync animate-spin text-3xl text-red-500 mb-4 block"></i>
                        <p class="text-xs uppercase font-bold tracking-widest">Đang chờ kết quả xổ số lúc 18:15...</p>
                        <p class="text-[10px] mt-2 text-gray-600">Kết quả được cập nhật tự động sau khi quay</p>
                    </div>
                    @endif

                    <div class="p-4 flex justify-end bg-[#0C0C0D] border-t border-white/5">
                        <a href="/lich-su/north" class="text-xs font-bold text-red-400 hover:text-red-300 uppercase tracking-widest">
                            Xem lịch sử kết quả <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </section>

                {{-- ── MIỀN TRUNG & MIỀN NAM ── --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Miền Trung --}}
                    <div class="glass-card rounded-2xl overflow-hidden border border-white/5">
                        <div class="p-4 bg-blue-500/10 flex justify-between items-center border-b border-white/5">
                            <h3 class="font-black text-white flex items-center gap-2 text-sm uppercase">
                                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span> Miền Trung
                            </h3>
                            <span class="text-[10px] font-bold text-blue-300 uppercase">{{ $lotteryMT['date'] ?? '17:15 hàng ngày' }}</span>
                        </div>
                        @if(isset($lotteryMT) && $lotteryMT && isset($lotteryMT['prizes']))
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-[10px] font-bold text-gray-500 uppercase">Đặc Biệt</span>
                                @php $mt_sp = $lotteryMT['prizes']['special'] ?? []; $mt_sp = is_array($mt_sp) ? ($mt_sp[0] ?? '-----') : $mt_sp; @endphp
                                <span class="text-xl font-black text-red-400 tracking-wider">{{ $mt_sp }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-[10px] font-bold text-gray-500 uppercase">Giải Nhất</span>
                                @php $mt_1 = $lotteryMT['prizes']['first'] ?? []; $mt_1 = is_array($mt_1) ? ($mt_1[0] ?? '-----') : $mt_1; @endphp
                                <span class="text-sm font-bold text-white">{{ $mt_1 }}</span>
                            </div>
                            @if(!empty($lotteryMT['prizes']['second']))
                            <div class="flex justify-between items-center py-2">
                                <span class="text-[10px] font-bold text-gray-500 uppercase">Giải Nhì</span>
                                @php $mt_2 = $lotteryMT['prizes']['second'] ?? []; @endphp
                                <span class="text-sm font-bold text-gray-300">
                                    {{ is_array($mt_2) ? implode(' · ', $mt_2) : $mt_2 }}
                                </span>
                            </div>
                            @endif
                            <a href="/lich-su/central" class="block text-center text-[10px] font-bold text-blue-400 hover:underline uppercase pt-2 border-t border-white/5">Xem đầy đủ →</a>
                        </div>
                        @else
                        <div class="flex items-center justify-center h-28 text-gray-600 italic text-xs uppercase font-semibold">
                            <i class="fas fa-clock mr-2"></i> Đang chờ kết quả lúc 17:15...
                        </div>
                        @endif
                    </div>

                    {{-- Miền Nam --}}
                    <div class="glass-card rounded-2xl overflow-hidden border border-white/5">
                        <div class="p-4 bg-green-500/10 flex justify-between items-center border-b border-white/5">
                            <h3 class="font-black text-white flex items-center gap-2 text-sm uppercase">
                                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span> Miền Nam
                            </h3>
                            <span class="text-[10px] font-bold text-green-300 uppercase">{{ $lotteryMN['date'] ?? '16:15 hàng ngày' }}</span>
                        </div>
                        @if(isset($lotteryMN) && $lotteryMN && isset($lotteryMN['prizes']))
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-[10px] font-bold text-gray-500 uppercase">Đặc Biệt</span>
                                @php $mn_sp = $lotteryMN['prizes']['special'] ?? []; $mn_sp = is_array($mn_sp) ? ($mn_sp[0] ?? '-----') : $mn_sp; @endphp
                                <span class="text-xl font-black text-red-400 tracking-wider">{{ $mn_sp }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-[10px] font-bold text-gray-500 uppercase">Giải Nhất</span>
                                @php $mn_1 = $lotteryMN['prizes']['first'] ?? []; $mn_1 = is_array($mn_1) ? ($mn_1[0] ?? '-----') : $mn_1; @endphp
                                <span class="text-sm font-bold text-white">{{ $mn_1 }}</span>
                            </div>
                            @if(!empty($lotteryMN['prizes']['second']))
                            <div class="flex justify-between items-center py-2">
                                <span class="text-[10px] font-bold text-gray-500 uppercase">Giải Nhì</span>
                                @php $mn_2 = $lotteryMN['prizes']['second'] ?? []; @endphp
                                <span class="text-sm font-bold text-gray-300">
                                    {{ is_array($mn_2) ? implode(' · ', $mn_2) : $mn_2 }}
                                </span>
                            </div>
                            @endif
                            <a href="/lich-su/south" class="block text-center text-[10px] font-bold text-green-400 hover:underline uppercase pt-2 border-t border-white/5">Xem đầy đủ →</a>
                        </div>
                        @else
                        <div class="flex items-center justify-center h-28 text-gray-600 italic text-xs uppercase font-semibold">
                            <i class="fas fa-clock mr-2"></i> Đang chờ kết quả lúc 16:15...
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ══ RIGHT: Sidebar ══ --}}
            <div class="lg:col-span-4 space-y-6">

                {{-- AI Prediction --}}
                <div class="glass-card rounded-3xl p-6 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-5">
                        <i class="fas fa-crown text-6xl text-yellow-500"></i>
                    </div>
                    <h3 class="text-base font-black text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-robot text-red-500"></i> SOI CẦU AI VIP 🧧
                    </h3>
                    @if(isset($predictionAI) && $predictionAI)
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center justify-between p-3 rounded-xl bg-white/5 border border-white/5">
                            <span class="text-xs font-bold text-gray-400 uppercase">Dàn Lô AI</span>
                            <div class="flex gap-2">
                                @foreach(array_slice($predictionAI['gemini']['numbers'] ?? [], 0, 3) as $num)
                                    <span class="ball ball-gold">{{ $num }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    <a href="/soi-cau" class="block w-full text-center gradient-brand py-3 rounded-2xl font-black text-white text-sm shadow-lg shadow-red-600/20 hover:opacity-90 transition uppercase">
                        Xem Soi Cầu AI <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                {{-- Quick Links --}}
                <div class="glass-card rounded-2xl p-5">
                    <h3 class="font-bold text-white mb-4 flex items-center gap-2 text-xs uppercase tracking-widest">
                        <i class="fas fa-link text-yellow-500"></i> TRUY CẬP NHANH
                    </h3>
                    <div class="space-y-2">
                        <a href="/lich-su/north" class="flex items-center gap-3 p-3 rounded-xl bg-white/5 hover:bg-white/10 transition text-sm font-semibold text-gray-300 hover:text-white">
                            <span class="w-6 h-6 rounded-lg bg-red-500/20 flex items-center justify-center text-[10px] text-red-400 font-black">MB</span>
                            Lịch Sử KQXS Miền Bắc
                        </a>
                        <a href="/lich-su/central" class="flex items-center gap-3 p-3 rounded-xl bg-white/5 hover:bg-white/10 transition text-sm font-semibold text-gray-300 hover:text-white">
                            <span class="w-6 h-6 rounded-lg bg-blue-500/20 flex items-center justify-center text-[10px] text-blue-400 font-black">MT</span>
                            Lịch Sử KQXS Miền Trung
                        </a>
                        <a href="/lich-su/south" class="flex items-center gap-3 p-3 rounded-xl bg-white/5 hover:bg-white/10 transition text-sm font-semibold text-gray-300 hover:text-white">
                            <span class="w-6 h-6 rounded-lg bg-green-500/20 flex items-center justify-center text-[10px] text-green-400 font-black">MN</span>
                            Lịch Sử KQXS Miền Nam
                        </a>
                        <a href="/quay-thu" class="flex items-center gap-3 p-3 rounded-xl bg-white/5 hover:bg-white/10 transition text-sm font-semibold text-gray-300 hover:text-white">
                            <span class="w-6 h-6 rounded-lg bg-purple-500/20 flex items-center justify-center text-[10px] text-purple-400 font-black"><i class="fas fa-dice text-[8px]"></i></span>
                            Quay Thử Xổ Số
                        </a>
                        <a href="/thong-ke" class="flex items-center gap-3 p-3 rounded-xl bg-white/5 hover:bg-white/10 transition text-sm font-semibold text-gray-300 hover:text-white">
                            <span class="w-6 h-6 rounded-lg bg-orange-500/20 flex items-center justify-center text-[10px] text-orange-400 font-black"><i class="fas fa-chart-bar text-[8px]"></i></span>
                            Thống Kê Xổ Số
                        </a>
                    </div>
                </div>

                {{-- Chat stub --}}
                <div class="glass-card rounded-2xl p-5">
                    <h3 class="font-bold text-white mb-4 flex items-center gap-2 text-xs uppercase tracking-widest">
                        <i class="fas fa-comments text-blue-400"></i> THẢO LUẬN
                    </h3>
                    <div class="space-y-3">
                        <div class="flex gap-3">
                            <div class="w-7 h-7 rounded-lg bg-gray-700 flex-shrink-0 flex items-center justify-center font-black text-[9px] text-white">TV</div>
                            <div class="bg-white/5 p-3 rounded-xl rounded-tl-none border border-white/5 flex-1">
                                <p class="text-[9px] font-bold text-gray-500 mb-1">Thành viên #284</p>
                                <p class="text-[11px] text-gray-300">Hy vọng hôm nay cầu 88 nổ rực rỡ! 🚀</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-7 h-7 rounded-lg gradient-brand flex-shrink-0 flex items-center justify-center font-black text-[9px] text-white">AI</div>
                            <div class="bg-white/5 p-3 rounded-xl rounded-tl-none border-l-2 border-red-500 flex-1">
                                <p class="text-[9px] font-black text-red-400 mb-1">Chuyên gia AI</p>
                                <p class="text-[11px] text-gray-300 italic">Cặp số hôm nay có biên độ rất đẹp!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
