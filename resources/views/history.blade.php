@extends('layouts.app')

@section('title', 'Lịch Sử Kết Quả Xổ Số - SOICAU7777')

@section('content')
<main class="max-w-7xl mx-auto px-4 py-12">
    <div class="mb-8 flex justify-between items-end border-b border-white/5 pb-6">
        <div>
            <h1 class="text-3xl font-extrabold text-white uppercase tracking-tighter">LỊCH SỬ KẾT QUẢ</h1>
            <p class="text-gray-500 text-sm mt-1 uppercase font-bold tracking-widest italic">Dữ liệu 20 kỳ quay gần nhất {{ $region == 'north' ? 'Miền Bắc' : ($region == 'central' ? 'Miền Trung' : 'Miền Nam') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="/lich-su/north" class="px-4 py-2 rounded-lg {{ $region == 'north' ? 'gradient-brand text-white' : 'glass-card text-gray-400' }} text-xs font-bold uppercase">Miền Bắc</a>
            <a href="/lich-su/central" class="px-4 py-2 rounded-lg {{ $region == 'central' ? 'gradient-brand text-white' : 'glass-card text-gray-400' }} text-xs font-bold uppercase">Miền Trung</a>
            <a href="/lich-su/south" class="px-4 py-2 rounded-lg {{ $region == 'south' ? 'gradient-brand text-white' : 'glass-card text-gray-400' }} text-xs font-bold uppercase">Miền Nam</a>
        </div>
    </div>

    <div class="space-y-6">
        @forelse($history as $result)
        <div class="glass-card rounded-2xl overflow-hidden border border-white/5">
            <div class="p-4 bg-white/5 flex justify-between items-center border-b border-white/5">
                <span class="text-xs font-black text-red-500 uppercase tracking-widest">Kỳ quay: {{ $result['date'] }}</span>
                <span class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">{{ $result['province'] ?? '' }}</span>
            </div>
            <div class="p-6 flex flex-wrap gap-4 items-center">
                <div class="flex-shrink-0 w-24">
                    <span class="text-[10px] font-bold text-gray-500 uppercase block mb-1">Đặc Biệt</span>
                    <span class="text-xl font-black text-white tracking-widest underline decoration-red-500 underline-offset-4">{{ $result['prizes']['special'][0] ?? ($result['numbers'][0] ?? '-----') }}</span>
                </div>
                <div class="flex-1">
                    <span class="text-[10px] font-bold text-gray-500 uppercase block mb-2">Dãy số loto (đầu/đuôi)</span>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $allNumbers = $result['numbers'] ?? [];
                            $lotoNumbers = array_map(function($n) { return substr($n, -2); }, $allNumbers);
                            $uniqueLoto = array_unique($lotoNumbers);
                            sort($uniqueLoto);
                        @endphp
                        @foreach(array_slice($uniqueLoto, 0, 15) as $num)
                            <span class="text-xs font-bold text-yellow-500 bg-white/5 px-2 py-1 rounded border border-white/5">{{ $num }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-20 text-gray-500 uppercase font-bold tracking-widest text-xs">Chưa có dữ liệu lịch sử.</div>
        @endforelse
    </div>
</main>
@endsection
