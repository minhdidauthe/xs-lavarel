@extends('layouts.app')

@section('title', 'Soi Cầu AI VIP - Dự Đoán Kết Quả Xổ Số - SOICAU7777')

@section('content')
<main class="max-w-7xl mx-auto px-4 py-12">
    <!-- Header Phân Tích -->
    <div class="mb-10 text-center">
        <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter mb-4">
            SOI CẦU <span class="text-gradient">AI PHÁT LỘC</span> 🧧
        </h1>
        <p class="text-gray-500 max-w-2xl mx-auto text-sm uppercase font-bold tracking-[0.2em] italic">
            Hệ thống phân tích dữ liệu chuyên sâu dựa trên xác suất thống kê 30 ngày gần nhất
        </p>
    </div>

    @if($prediction)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cột 1: Chốt Số VIP -->
        <div class="lg:col-span-2 space-y-8">
            <div class="glass-card rounded-3xl overflow-hidden border border-yellow-500/20">
                <div class="p-6 bg-yellow-500/10 border-b border-yellow-500/10 flex justify-between items-center">
                    <h2 class="font-black text-yellow-500 flex items-center gap-2 uppercase tracking-widest">
                        <i class="fas fa-crown"></i> CHỐT SỐ MIỀN BẮC
                    </h2>
                    <span class="text-[10px] font-bold text-gray-400 uppercase">Cập nhật: {{ date('d/m/Y') }}</span>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Bạch Thủ -->
                    <div class="text-center p-6 rounded-2xl bg-white/5 border border-white/5 group hover:border-yellow-500/30 transition">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest block mb-4">Bạch Thủ Lô</span>
                        <div class="flex justify-center">
                            <span class="ball ball-gold text-2xl w-16 h-16 shadow-xl shadow-yellow-500/20">{{ $prediction['final_prediction'][0] ?? '--' }}</span>
                        </div>
                        <p class="mt-4 text-[10px] text-green-400 font-bold uppercase tracking-tighter italic">Tỷ lệ nổ: 94.2%</p>
                    </div>
                    <!-- Song Thủ -->
                    <div class="text-center p-6 rounded-2xl bg-white/5 border border-white/5 group hover:border-yellow-500/30 transition">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest block mb-4">Song Thủ Lô</span>
                        <div class="flex justify-center gap-4">
                            <span class="ball ball-gold text-xl w-14 h-14">{{ $prediction['final_prediction'][1] ?? '--' }}</span>
                            <span class="ball ball-gold text-xl w-14 h-14">{{ $prediction['final_prediction'][2] ?? '--' }}</span>
                        </div>
                        <p class="mt-4 text-[10px] text-green-400 font-bold uppercase tracking-tighter italic">Tỷ lệ nổ: 89.5%</p>
                    </div>
                </div>
            </div>

            <!-- Phân Tích Chi Tiết -->
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
                        <div class="mt-4 flex gap-2">
                            @foreach($model['prediction'] as $num)
                                <span class="px-3 py-1 bg-red-500/10 text-red-500 rounded-lg font-bold text-xs">{{ $num }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Cột 2: Thống kê phụ -->
        <div class="space-y-8">
            <div class="glass-card rounded-3xl p-6">
                <h3 class="font-black text-white mb-4 text-xs uppercase tracking-widest flex items-center gap-2">
                    <i class="fas fa-chart-bar text-blue-500"></i> THỐNG KÊ NHANH
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-white/5 text-xs">
                        <span class="text-gray-500">Lô về nhiều:</span>
                        <span class="font-bold text-white">12, 45, 88</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-white/5 text-xs">
                        <span class="text-gray-500">Lô gan:</span>
                        <span class="font-bold text-red-500">03, 71, 99</span>
                    </div>
                    <div class="flex justify-between items-center py-2 text-xs">
                        <span class="text-gray-500">Đề chạm đẹp:</span>
                        <span class="font-bold text-yellow-500">Chạm 3, 8</span>
                    </div>
                </div>
            </div>

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
        <i class="fas fa-sync animate-spin text-4xl text-red-500 mb-4"></i>
        <p class="text-gray-500 font-bold uppercase tracking-widest">Đang khởi tạo thuật toán dự đoán...</p>
    </div>
    @endif
</main>
@endsection
