@extends('layouts.app')

@section('title', 'Soi Cầu AI VIP - Dự Đoán Kết Quả Xổ Số - SOICAU7777')

@section('content')
<main class="max-w-7xl mx-auto px-4 py-12">
    <!-- Header -->
    <div class="mb-10 text-center">
        <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter mb-4">
            SOI CẦU <span class="text-gradient">AI PHÁT LỘC</span>
        </h1>
        <p class="text-gray-500 max-w-2xl mx-auto text-sm uppercase font-bold tracking-[0.2em] italic">
            Hệ thống phân tích dữ liệu chuyên sâu · Thuật toán Scoring 7 lớp · Dữ liệu 180 ngày
        </p>
    </div>

    @if($prediction)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cột 1: Chốt Số VIP + Phân Tích -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Chốt Số -->
            <div class="glass-card rounded-3xl overflow-hidden border border-yellow-500/20">
                <div class="p-6 bg-yellow-500/10 border-b border-yellow-500/10 flex justify-between items-center">
                    <h2 class="font-black text-yellow-500 flex items-center gap-2 uppercase tracking-widest">
                        <i class="fas fa-crown"></i> CHỐT SỐ MIỀN BẮC
                    </h2>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">{{ $prediction['details']['predict_date'] ?? date('d/m/Y') }}</span>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Bạch Thủ -->
                    <div class="text-center p-6 rounded-2xl bg-white/5 border border-white/5 group hover:border-yellow-500/30 transition">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest block mb-4">Bạch Thủ Lô</span>
                        <div class="flex justify-center">
                            <span class="ball ball-gold text-2xl w-16 h-16 shadow-xl shadow-yellow-500/20">{{ $prediction['final_prediction'][0] ?? '--' }}</span>
                        </div>
                        <p class="mt-4 text-[10px] text-green-400 font-bold uppercase tracking-tighter italic">
                            Điểm: {{ $prediction['top10'][0]['score'] ?? '-' }}
                        </p>
                    </div>
                    <!-- Song Thủ -->
                    <div class="text-center p-6 rounded-2xl bg-white/5 border border-white/5 group hover:border-yellow-500/30 transition">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest block mb-4">Song Thủ Lô</span>
                        <div class="flex justify-center gap-4">
                            <span class="ball ball-gold text-xl w-14 h-14">{{ $prediction['final_prediction'][1] ?? '--' }}</span>
                            <span class="ball ball-gold text-xl w-14 h-14">{{ $prediction['final_prediction'][2] ?? '--' }}</span>
                        </div>
                        <p class="mt-4 text-[10px] text-green-400 font-bold uppercase tracking-tighter italic">
                            Điểm: {{ $prediction['top10'][1]['score'] ?? '-' }} · {{ $prediction['top10'][2]['score'] ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Nhận Định AI -->
            <div class="glass-card rounded-3xl p-8">
                <h3 class="text-xl font-black text-white mb-6 uppercase tracking-tighter flex items-center gap-3">
                    <i class="fas fa-brain text-red-500"></i> NHẬN ĐỊNH CỦA CHUYÊN GIA AI
                </h3>
                <div class="space-y-6">
                    @foreach($prediction['model_predictions'] ?? [] as $model)
                    <div class="p-5 rounded-2xl bg-white/5 border-l-4 border-red-500">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-black text-red-500 uppercase">{{ $model['model'] }}</span>
                            <span class="text-[10px] text-gray-500">Độ tin cậy: Cao</span>
                        </div>
                        <p class="text-sm text-gray-300 leading-relaxed italic">"{{ $model['reasoning'] }}"</p>
                        <div class="mt-4 flex gap-2 flex-wrap">
                            @foreach($model['prediction'] as $num)
                                <span class="px-3 py-1 bg-red-500/10 text-red-500 rounded-lg font-bold text-xs">{{ $num }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Bảng Xếp Hạng Top 10 -->
            <div class="glass-card rounded-3xl overflow-hidden">
                <div class="p-6 border-b border-white/5 flex items-center gap-2">
                    <i class="fas fa-trophy text-yellow-500"></i>
                    <h3 class="font-black text-white uppercase tracking-widest text-sm">BẢNG XẾP HẠNG ĐIỂM SỐ</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-white/5 text-gray-500 text-[10px] uppercase tracking-widest">
                                <th class="py-3 px-4 text-left">#</th>
                                <th class="py-3 px-4 text-center">Số</th>
                                <th class="py-3 px-4 text-right">Điểm</th>
                                <th class="py-3 px-4 text-left">Lý do</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prediction['top10'] as $idx => $item)
                            <tr class="border-b border-white/5 {{ $idx < 3 ? 'bg-yellow-500/5' : '' }}">
                                <td class="py-3 px-4 font-bold {{ $idx < 3 ? 'text-yellow-500' : 'text-gray-500' }}">{{ $idx + 1 }}</td>
                                <td class="py-3 px-4 text-center">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full font-black text-sm {{ $idx === 0 ? 'bg-yellow-500/20 text-yellow-400' : ($idx < 3 ? 'bg-red-500/10 text-red-400' : 'bg-white/5 text-white') }}">
                                        {{ $item['number'] }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-right font-bold {{ $idx < 3 ? 'text-yellow-400' : 'text-gray-300' }}">
                                    {{ $item['score'] }}
                                </td>
                                <td class="py-3 px-4 text-xs text-gray-400">
                                    @if(!empty($item['reasons']))
                                        @foreach($item['reasons'] as $reason)
                                            <span class="inline-block px-2 py-0.5 bg-white/5 rounded text-[10px] mr-1 mb-1">{{ $reason }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-600 italic">Tổng hợp nhiều yếu tố</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Cột 2: Sidebar -->
        <div class="space-y-8">
            <!-- Thống Kê Nhanh -->
            <div class="glass-card rounded-3xl p-6">
                <h3 class="font-black text-white mb-4 text-xs uppercase tracking-widest flex items-center gap-2">
                    <i class="fas fa-chart-bar text-blue-500"></i> THỐNG KÊ NHANH
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-white/5 text-xs">
                        <span class="text-gray-500">Lô về nhiều:</span>
                        <span class="font-bold text-white">
                            @php
                                $hotNums = collect($prediction['top10'])->filter(fn($t) => in_array('Tần suất cao (45 ngày)', $t['reasons']))->pluck('number')->take(3);
                                echo $hotNums->isEmpty() ? collect($prediction['top10'])->pluck('number')->take(3)->join(', ') : $hotNums->join(', ');
                            @endphp
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-white/5 text-xs">
                        <span class="text-gray-500">Lô gan:</span>
                        <span class="font-bold text-red-500">
                            @php
                                $ganNums = collect($prediction['top10'])->filter(fn($t) => collect($t['reasons'])->contains(fn($r) => str_contains($r, 'Lô gan')))->pluck('number')->take(3);
                                echo $ganNums->isEmpty() ? '---' : $ganNums->join(', ');
                            @endphp
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-white/5 text-xs">
                        <span class="text-gray-500">Cầu láng giềng:</span>
                        <span class="font-bold text-yellow-500">
                            @php
                                $neighborNums = collect($prediction['top10'])->filter(fn($t) => in_array('Cầu láng giềng GĐB', $t['reasons']))->pluck('number')->take(3);
                                echo $neighborNums->isEmpty() ? '---' : $neighborNums->join(', ');
                            @endphp
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2 text-xs">
                        <span class="text-gray-500">GĐB hôm qua:</span>
                        <span class="font-bold text-green-400">
                            {{ $prediction['details']['yesterday_special'] !== null ? str_pad($prediction['details']['yesterday_special'], 2, '0', STR_PAD_LEFT) : '---' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Thông tin thuật toán -->
            <div class="glass-card rounded-3xl p-6">
                <h3 class="font-black text-white mb-4 text-xs uppercase tracking-widest flex items-center gap-2">
                    <i class="fas fa-cog text-purple-500"></i> THUẬT TOÁN
                </h3>
                <div class="space-y-2 text-[11px] text-gray-500">
                    <div class="flex justify-between py-1">
                        <span>Dữ liệu phân tích:</span>
                        <span class="text-white font-bold">{{ $prediction['details']['history_days'] ?? 0 }} ngày</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span>Các yếu tố:</span>
                        <span class="text-white font-bold">7 lớp</span>
                    </div>
                    <div class="space-y-1 mt-3 pt-3 border-t border-white/5">
                        <p>1. Xuất hiện gần (14 ngày)</p>
                        <p>2. Tần suất (45 + 180 ngày)</p>
                        <p>3. Cầu láng giềng GĐB</p>
                        <p>4. Chu kỳ 7 ngày & 30 ngày</p>
                        <p>5. Lô gan (dài ngày)</p>
                        <p>6. Phạt số vừa về</p>
                        <p>7. Tổng hợp trọng số</p>
                    </div>
                </div>
            </div>

            <!-- Lưu ý -->
            <div class="glass-card rounded-3xl p-6 bg-gradient-to-br from-red-600/10 to-transparent">
                <h3 class="font-black text-white mb-4 text-xs uppercase tracking-widest">LƯU Ý QUAN TRỌNG</h3>
                <p class="text-[11px] text-gray-500 leading-relaxed italic">
                    Mọi thông tin soi cầu đều dựa trên thuật toán máy tính và mang tính chất tham khảo. Chúc bạn có những quyết định sáng suốt và gặp nhiều may mắn!
                </p>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-20">
        <i class="fas fa-database text-4xl text-red-500 mb-4"></i>
        <p class="text-gray-500 font-bold uppercase tracking-widest">Chưa có đủ dữ liệu để phân tích</p>
        <p class="text-gray-600 text-xs mt-2">Cần chạy crawler để thu thập lịch sử kết quả xổ số</p>
    </div>
    @endif
</main>
@endsection
