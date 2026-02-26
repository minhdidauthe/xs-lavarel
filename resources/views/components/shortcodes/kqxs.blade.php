<div class="shortcode-kqxs glass-card rounded-2xl overflow-hidden my-6">
    <div class="p-4 bg-white/5 border-b border-white/10 flex justify-between items-center">
        <h3 class="font-black text-white text-sm uppercase tracking-widest">
            <i class="fas fa-trophy text-yellow-500 mr-2"></i>
            KQXS {{ $region === 'MB' ? 'Miền Bắc' : ($region === 'MN' ? 'Miền Nam' : 'Miền Trung') }}
        </h3>
        <span class="text-[10px] text-gray-400">{{ $result->date->format('d/m/Y') }} &middot; {{ $result->province }}</span>
    </div>
    <div class="p-4 overflow-x-auto">
        <table class="w-full text-sm">
            <tbody>
                @foreach(['special' => 'Giải ĐB', 'first' => 'Giải nhất', 'second' => 'Giải nhì', 'third' => 'Giải ba', 'fourth' => 'Giải tư', 'fifth' => 'Giải năm', 'sixth' => 'Giải sáu', 'seventh' => 'Giải bảy', 'eighth' => 'Giải tám'] as $key => $label)
                    @if(!empty($result->prizes[$key]))
                    <tr class="border-b border-white/5">
                        <td class="py-2 px-3 text-xs text-gray-500 font-bold w-24 {{ $key === 'special' ? 'text-red-500' : '' }}">{{ $label }}</td>
                        <td class="py-2 px-3 text-center">
                            @foreach($result->prizes[$key] as $num)
                                <span class="inline-block px-2 py-0.5 font-bold {{ $key === 'special' ? 'text-red-500 text-lg' : 'text-white' }}">{{ $num }}</span>
                            @endforeach
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
