@extends('layouts.app')

@section('title', 'SOICAU7777.CLICK - Trực Tiếp Kết Quả Xổ Số 3 Miền')

@section('content')
    <!-- Hero Banner -->
    <div class="relative py-12 overflow-hidden border-b border-white/5 bg-gradient-to-b from-red-950/20 to-transparent">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 tracking-tight">KẾT QUẢ XỔ SỐ <span class="text-gradient uppercase">Siêu Tốc</span></h1>
            <p class="text-gray-400 max-w-2xl mx-auto text-lg">Chào mừng bạn đã trở lại! 🧧 Hệ thống cập nhật kết quả tự động, chính xác và nhanh nhất Việt Nam.</p>
            
            <div class="mt-10 flex flex-wrap justify-center gap-3">
                <div class="glass-card px-6 py-3 rounded-2xl flex items-center gap-3">
                    <i class="fas fa-bolt text-yellow-500"></i>
                    <span class="text-sm font-medium">Cập nhật (VN): <span class="text-white">{{ now()->timezone('Asia/Ho_Chi_Minh')->format('H:i:s') }}</span></span>
                </div>
                <div class="glass-card px-6 py-3 rounded-2xl flex items-center gap-3 border-green-500/20">
                    <span class="flex h-2 w-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-sm font-medium">Máy chủ: <span class="text-green-400 uppercase font-bold">Trực Tuyến</span></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Column: Results -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Miền Bắc -->
                <section class="glass-card rounded-3xl overflow-hidden shadow-2xl border border-white/10">
                    <div class="p-5 gradient-brand flex justify-between items-center shadow-inner">
                        <div class="flex items-center gap-3 text-white">
                            <i class="fas fa-star-and-crescent text-2xl"></i>
                            <div>
                                <h2 class="text-xl font-extrabold leading-none tracking-tight uppercase">XỔ SỐ MIỀN BẮC</h2>
                                <p class="text-[10px] opacity-80 mt-1 font-bold uppercase">Trực tiếp lúc 18:15 hàng ngày</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="block text-xs font-bold text-white/70 uppercase">Ngày quay</span>
                            <span class="text-lg font-black text-white italic tracking-tighter">{{ $lotteryMB['date'] ?? date('d/m/Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="bg-[#0C0C0D]">
                        @if($lotteryMB && isset($lotteryMB['prizes']))
                        <table class="w-full text-center border-collapse">
                            <tbody>
                                <!-- ĐẶC BIỆT -->
                                <tr class="border-b border-white/5 bg-red-500/5">
                                    <td class="py-6 px-4 w-32 font-bold text-red-500 text-sm border-r border-white/5 uppercase">Đặc Biệt</td>
                                    <td class="py-6 px-4">
                                        <div class="flex justify-center gap-3">
                                            @php 
                                                $sp = $lotteryMB['prizes']['special'] ?? '-----';
                                                $spStr = is_array($sp) ? ($sp[0] ?? '-----') : $sp;
                                                $specialDigits = str_split($spStr); 
                                            @endphp
                                            @foreach($specialDigits as $digit)
                                                <span class="ball ball-red text-2xl">{{ $digit }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <!-- GIẢI NHẤT -->
                                <tr class="border-b border-white/5">
                                    <td class="py-4 px-4 w-32 font-bold text-gray-400 text-xs border-r border-white/5 uppercase tracking-widest">Giải Nhất</td>
                                    <td class="py-4 px-4 text-2xl font-black text-white tracking-[0.3em]">{{ $lotteryMB['prizes']['first'][0] ?? '-----' }}</td>
                                </tr>
                                <!-- GIẢI NHÌ -->
                                <tr class="border-b border-white/5">
                                    <td class="py-4 px-4 w-32 font-bold text-gray-400 text-xs border-r border-white/5 uppercase tracking-widest">Giải Nhì</td>
                                    <td class="py-4 px-4 text-xl font-bold text-gray-200 tracking-[0.2em]">
                                        {{ implode(' - ', $lotteryMB['prizes']['second'] ?? ['-----', '-----']) }}
                                    </td>
                                </tr>
                                <!-- GIẢI BA -->
                                <tr class="border-b border-white/5">
                                    <td class="py-4 px-4 w-32 font-bold text-gray-400 text-xs border-r border-white/5 uppercase tracking-widest">Giải Ba</td>
                                    <td class="py-4 px-4">
                                        <div class="grid grid-cols-3 gap-4 text-lg font-bold text-gray-300 tracking-wider">
                                            @foreach($lotteryMB['prizes']['third'] ?? [] as $p)
                                                <span>{{ $p }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <!-- GIẢI TƯ -->
                                <tr class="border-b border-white/5">
                                    <td class="py-4 px-4 w-32 font-bold text-gray-400 text-xs border-r border-white/5 uppercase tracking-widest">Giải Tư</td>
                                    <td class="py-4 px-4">
                                        <div class="grid grid-cols-4 gap-4 text-base font-bold text-gray-400 tracking-wider">
                                            @foreach($lotteryMB['prizes']['fourth'] ?? [] as $p)
                                                <span>{{ $p }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <!-- GIẢI NĂM -->
                                <tr class="border-b border-white/5">
                                    <td class="py-4 px-4 w-32 font-bold text-gray-400 text-xs border-r border-white/5 uppercase tracking-widest">Giải Năm</td>
                                    <td class="py-4 px-4">
                                        <div class="grid grid-cols-3 gap-4 text-lg font-bold text-gray-300 tracking-wider">
                                            @foreach($lotteryMB['prizes']['fifth'] ?? [] as $p)
                                                <span>{{ $p }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <!-- GIẢI SÁU -->
                                <tr class="border-b border-white/5">
                                    <td class="py-4 px-4 w-32 font-bold text-gray-400 text-xs border-r border-white/5 uppercase tracking-widest text-[10px]">Giải Sáu</td>
                                    <td class="py-4 px-4">
                                        <div class="grid grid-cols-3 gap-8 text-xl font-black text-white tracking-widest italic">
                                            @foreach($lotteryMB['prizes']['sixth'] ?? [] as $p)
                                                <span>{{ $p }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <!-- GIẢI BẢY -->
                                <tr>
                                    <td class="py-4 px-4 w-32 font-bold text-gray-400 text-xs border-r border-white/5 uppercase tracking-widest text-[10px]">Giải Bảy</td>
                                    <td class="py-4 px-4">
                                        <div class="flex justify-around text-xl font-black text-red-500/80 tracking-widest">
                                            @foreach($lotteryMB['prizes']['seventh'] ?? [] as $p)
                                                <span>{{ $p }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <div class="text-center py-20 text-gray-500 uppercase font-bold tracking-widest text-xs">
                            <i class="fas fa-sync animate-spin mb-4 text-3xl text-red-500"></i>
                            <p>Đang tải kết quả...</p>
                        </div>
                        @endif
                    </div>
                </section>

                <!-- Grid: MT & MN (Dạng nhỏ gọn) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Miền Trung -->
                    <div class="glass-card rounded-2xl p-5 border border-white/5">
                        <div class="flex justify-between items-center mb-4 border-b border-white/5 pb-3">
                            <h3 class="font-black text-white flex items-center gap-2 uppercase tracking-tighter">
                                <span class="w-2 h-2 rounded-full bg-blue-500 {{ isset($lotteryMT) ? '' : 'animate-pulse' }}"></span>
                                Miền Trung
                            </h3>
                            <span class="text-[9px] font-bold text-blue-400 uppercase tracking-widest">
                                {{ $lotteryMT['date'] ?? 'Đang chờ 17:15' }}
                            </span>
                        </div>
                        @if(isset($lotteryMT) && $lotteryMT)
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-gray-500 uppercase">Đặc Biệt</span>
                                <span class="text-xl font-black text-red-500 tracking-wider">{{ $lotteryMT['prizes']['special'][0] ?? '-----' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-gray-500 uppercase">Giải Nhất</span>
                                <span class="text-sm font-bold text-white">{{ $lotteryMT['prizes']['first'][0] ?? '-----' }}</span>
                            </div>
                            <div class="pt-2 border-t border-white/5 text-center">
                                <a href="/lich-su/central" class="text-[9px] font-bold text-blue-400 hover:underline uppercase">Xem đầy đủ chi tiết</a>
                            </div>
                        </div>
                        @else
                        <div class="flex items-center justify-center h-32 text-gray-600 italic text-xs uppercase font-medium">
                            Dữ liệu đang cập nhật...
                        </div>
                        @endif
                    </div>

                    <!-- Miền Nam -->
                    <div class="glass-card rounded-2xl p-5 border border-white/5">
                        <div class="flex justify-between items-center mb-4 border-b border-white/5 pb-3">
                            <h3 class="font-black text-white flex items-center gap-2 uppercase tracking-tighter">
                                <span class="w-2 h-2 rounded-full bg-green-500 {{ isset($lotteryMN) ? '' : 'animate-pulse' }}"></span>
                                Miền Nam
                            </h3>
                            <span class="text-[9px] font-bold text-green-400 uppercase tracking-widest">
                                {{ $lotteryMN['date'] ?? 'Đang chờ 16:15' }}
                            </span>
                        </div>
                        @if(isset($lotteryMN) && $lotteryMN)
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-gray-500 uppercase">Đặc Biệt</span>
                                <span class="text-xl font-black text-red-500 tracking-wider">{{ $lotteryMN['prizes']['special'][0] ?? '-----' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-bold text-gray-500 uppercase">Giải Nhất</span>
                                <span class="text-sm font-bold text-white">{{ $lotteryMN['prizes']['first'][0] ?? '-----' }}</span>
                            </div>
                            <div class="pt-2 border-t border-white/5 text-center">
                                <a href="/lich-su/south" class="text-[9px] font-bold text-green-400 hover:underline uppercase">Xem đầy đủ chi tiết</a>
                            </div>
                        </div>
                        @else
                        <div class="flex items-center justify-center h-32 text-gray-600 italic text-xs uppercase font-medium">
                            Dữ liệu đang cập nhật...
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar for Users -->
            <div class="lg:col-span-4 space-y-8">
                <!-- VIP Predictions -->
                <div class="glass-card rounded-3xl p-8 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                        <i class="fas fa-crown text-6xl text-yellow-500"></i>
                    </div>
                    <h3 class="text-xl font-black text-white mb-6 flex items-center gap-3">
                        <i class="fas fa-robot text-red-500"></i>
                        SOI CẦU AI VIP 🧧
                    </h3>
                    @if($predictionAI)
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 rounded-2xl bg-white/5 border border-white/5">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Dàn Lô AI</span>
                            <div class="flex gap-2">
                                @foreach(array_slice($predictionAI['gemini']['numbers'] ?? [], 0, 3) as $num)
                                    <span class="ball ball-gold">{{ $num }}</span>
                                @endforeach
                            </div>
                        </div>
                        <button class="w-full gradient-brand py-4 rounded-2xl font-black text-white shadow-xl shadow-red-600/20 hover:scale-[1.02] transition uppercase">Xem tất cả</button>
                    </div>
                    @endif
                </div>

                <!-- Discussion -->
                <div class="glass-card rounded-3xl p-6">
                    <h3 class="font-bold text-white mb-4 flex items-center gap-2 text-xs uppercase tracking-widest">
                        <i class="fas fa-comments text-blue-500"></i>
                        THẢO LUẬN
                    </h3>
                    <div class="space-y-4 mb-6">
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-700 flex-shrink-0 flex items-center justify-center font-bold text-[10px] text-white uppercase">TV</div>
                            <div class="bg-white/5 p-3 rounded-2xl rounded-tl-none border border-white/5">
                                <p class="text-[9px] font-bold text-gray-400 mb-1 uppercase">Thành viên #284</p>
                                <p class="text-[11px] text-gray-300">Hy vọng hôm nay cầu 88 nổ rực rỡ! 🚀</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-8 h-8 rounded-lg gradient-brand flex-shrink-0 flex items-center justify-center font-bold text-[10px] text-white uppercase">AI</div>
                            <div class="bg-white/5 p-3 rounded-2xl rounded-tl-none border-l-2 border-red-500 border-red-500/20">
                                <p class="text-[9px] font-black text-red-500 mb-1 uppercase">Chuyên gia AI</p>
                                <p class="text-[11px] text-gray-300 italic">Cặp số hôm nay có biên độ rất đẹp!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
