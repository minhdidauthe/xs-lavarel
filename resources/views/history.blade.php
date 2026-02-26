@extends('layouts.app')

@section('title', 'Lịch Sử Kết Quả Xổ Số - SOICAU7777')

@section('content')
<main class="max-w-7xl mx-auto px-4 py-10">

    {{-- Header --}}
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-white/5 pb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-white uppercase tracking-tighter">Lịch Sử Kết Quả</h1>
            <p class="text-gray-500 text-xs mt-1 uppercase font-bold tracking-widest">
                20 kỳ quay gần nhất ·
                @if($region === 'north') Miền Bắc
                @elseif($region === 'central') Miền Trung
                @else Miền Nam
                @endif
            </p>
        </div>
        <div class="flex gap-2 flex-wrap">
            <a href="/lich-su/north" class="px-4 py-2 rounded-lg {{ $region === 'north' ? 'gradient-brand text-white' : 'glass-card text-gray-400 hover:text-white' }} text-xs font-bold uppercase transition">
                Miền Bắc
            </a>
            <a href="/lich-su/central" class="px-4 py-2 rounded-lg {{ $region === 'central' ? 'gradient-brand text-white' : 'glass-card text-gray-400 hover:text-white' }} text-xs font-bold uppercase transition">
                Miền Trung
            </a>
            <a href="/lich-su/south" class="px-4 py-2 rounded-lg {{ $region === 'south' ? 'gradient-brand text-white' : 'glass-card text-gray-400 hover:text-white' }} text-xs font-bold uppercase transition">
                Miền Nam
            </a>
        </div>
    </div>

    {{-- Results list --}}
    <div class="space-y-6">
        @forelse($history as $result)
        @php
            $prizes = $result['prizes'] ?? [];
            $sp = $prizes['special'] ?? [];
            $spStr = is_array($sp) ? ($sp[0] ?? '-----') : ($sp ?: '-----');
            $allNumbers = $result['numbers'] ?? [];
            $lotoTails = array_unique(array_map(fn($n) => substr($n, -2), $allNumbers));
            sort($lotoTails);
        @endphp
        <div class="glass-card rounded-2xl overflow-hidden border border-white/5">

            {{-- Card Header --}}
            <div class="p-4 bg-white/[0.03] flex flex-wrap justify-between items-center gap-2 border-b border-white/5">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-black text-red-400 uppercase tracking-widest">
                        <i class="fas fa-calendar-alt mr-1"></i> {{ $result['date'] ?? '---' }}
                    </span>
                    @if(!empty($result['province']))
                    <span class="text-[10px] text-gray-500 bg-white/5 px-2 py-0.5 rounded-full font-bold uppercase">{{ $result['province'] }}</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold text-gray-600 uppercase">Đặc biệt:</span>
                    <span class="text-base font-black text-white tracking-widest underline decoration-red-500 underline-offset-4">{{ $spStr }}</span>
                </div>
            </div>

            {{-- Prize Table --}}
            @if(!empty($prizes))
            <div class="overflow-x-auto">
                <table class="w-full text-center border-collapse text-xs">
                    <tbody>
                        @if(!empty($prizes['first']))
                        <tr class="border-b border-white/5">
                            <td class="py-2 px-3 w-24 font-bold text-gray-600 border-r border-white/5 uppercase text-[10px]">G.Nhất</td>
                            <td class="py-2 px-3 font-bold text-gray-200 tracking-wider">
                                {{ is_array($prizes['first']) ? implode(' · ', $prizes['first']) : $prizes['first'] }}
                            </td>
                        </tr>
                        @endif
                        @if(!empty($prizes['second']))
                        <tr class="border-b border-white/5 bg-white/[0.015]">
                            <td class="py-2 px-3 font-bold text-gray-600 border-r border-white/5 uppercase text-[10px]">G.Nhì</td>
                            <td class="py-2 px-3 font-bold text-gray-300 tracking-wider">
                                {{ is_array($prizes['second']) ? implode(' · ', $prizes['second']) : $prizes['second'] }}
                            </td>
                        </tr>
                        @endif
                        @if(!empty($prizes['third']))
                        <tr class="border-b border-white/5">
                            <td class="py-2 px-3 font-bold text-gray-600 border-r border-white/5 uppercase text-[10px]">G.Ba</td>
                            <td class="py-2 px-3">
                                <div class="flex flex-wrap justify-center gap-x-4 gap-y-1 font-bold text-gray-400">
                                    @foreach((array)$prizes['third'] as $p)
                                        <span>{{ is_array($p) ? $p[0] : $p }}</span>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        @endif
                        @if(!empty($prizes['fourth']))
                        <tr class="border-b border-white/5 bg-white/[0.015]">
                            <td class="py-2 px-3 font-bold text-gray-600 border-r border-white/5 uppercase text-[10px]">G.Tư</td>
                            <td class="py-2 px-3">
                                <div class="flex flex-wrap justify-center gap-x-4 gap-y-1 font-bold text-gray-500">
                                    @foreach((array)$prizes['fourth'] as $p)
                                        <span>{{ is_array($p) ? $p[0] : $p }}</span>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        @endif
                        @if(!empty($prizes['fifth']))
                        <tr class="border-b border-white/5">
                            <td class="py-2 px-3 font-bold text-gray-600 border-r border-white/5 uppercase text-[10px]">G.Năm</td>
                            <td class="py-2 px-3">
                                <div class="flex flex-wrap justify-center gap-x-4 gap-y-1 font-bold text-gray-400">
                                    @foreach((array)$prizes['fifth'] as $p)
                                        <span>{{ is_array($p) ? $p[0] : $p }}</span>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                        @endif
                        @if(!empty($prizes['sixth']))
                        <tr class="border-b border-white/5 bg-white/[0.015]">
                            <td class="py-2 px-3 font-bold text-gray-600 border-r border-white/5 uppercase text-[10px]">G.Sáu</td>
                            <td class="py-2 px-3 font-bold text-white tracking-widest">
                                {{ is_array($prizes['sixth']) ? implode('  ·  ', $prizes['sixth']) : $prizes['sixth'] }}
                            </td>
                        </tr>
                        @endif
                        @if(!empty($prizes['seventh']))
                        <tr>
                            <td class="py-2 px-3 font-bold text-gray-600 border-r border-white/5 uppercase text-[10px]">G.Bảy</td>
                            <td class="py-2 px-3 font-bold text-red-400 tracking-widest">
                                {{ is_array($prizes['seventh']) ? implode('  ·  ', $prizes['seventh']) : $prizes['seventh'] }}
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Lô tô tails --}}
            @if(!empty($lotoTails))
            <div class="p-3 border-t border-white/5 bg-white/[0.015]">
                <span class="text-[9px] font-bold text-gray-600 uppercase mr-2">Lô tô:</span>
                @foreach(array_slice($lotoTails, 0, 20) as $num)
                    <span class="inline-block text-[10px] font-bold text-yellow-400 bg-white/5 px-1.5 py-0.5 rounded mr-1 mb-1">{{ $num }}</span>
                @endforeach
            </div>
            @endif
        </div>
        @empty
        <div class="text-center py-24 text-gray-500">
            <i class="fas fa-database text-3xl mb-4 block text-gray-700"></i>
            <p class="text-xs uppercase font-bold tracking-widest">Chưa có dữ liệu lịch sử.</p>
            <p class="text-[10px] mt-2 text-gray-700">Dữ liệu sẽ được cập nhật sau khi crawler chạy.</p>
        </div>
        @endforelse
    </div>

</main>
@endsection
