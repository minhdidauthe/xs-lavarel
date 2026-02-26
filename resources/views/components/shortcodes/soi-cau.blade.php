<div class="shortcode-soicau glass-card rounded-2xl overflow-hidden my-6">
    <div class="p-4 bg-yellow-500/10 border-b border-yellow-500/10">
        <h3 class="font-black text-yellow-500 text-sm uppercase tracking-widest">
            <i class="fas fa-brain mr-2"></i> SOI CẦU AI — TOP 10
        </h3>
        <p class="text-[10px] text-gray-500 mt-1">{{ $prediction['details']['predict_date'] ?? date('d/m/Y') }}</p>
    </div>
    <div class="p-4">
        <div class="flex flex-wrap gap-3 mb-4 justify-center">
            @foreach(array_slice($prediction['top10'], 0, 3) as $idx => $item)
                <div class="text-center">
                    <span class="inline-flex items-center justify-center w-14 h-14 rounded-full font-black text-lg bg-yellow-500/20 text-yellow-400 border-2 border-yellow-500/30">
                        {{ $item['number'] }}
                    </span>
                    <p class="text-[10px] text-green-400 mt-1 font-bold">{{ $item['score'] }}</p>
                </div>
            @endforeach
        </div>
        <table class="w-full text-xs">
            <thead>
                <tr class="text-gray-500 border-b border-white/5">
                    <th class="py-2 text-left">#</th>
                    <th class="py-2 text-center">Số</th>
                    <th class="py-2 text-right">Điểm</th>
                    <th class="py-2 text-left pl-4">Lý do</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prediction['top10'] as $idx => $item)
                <tr class="border-b border-white/5 {{ $idx < 3 ? 'bg-yellow-500/5' : '' }}">
                    <td class="py-2 font-bold {{ $idx < 3 ? 'text-yellow-500' : 'text-gray-500' }}">{{ $idx + 1 }}</td>
                    <td class="py-2 text-center font-black {{ $idx < 3 ? 'text-yellow-400' : 'text-white' }}">{{ $item['number'] }}</td>
                    <td class="py-2 text-right font-bold {{ $idx < 3 ? 'text-yellow-400' : 'text-gray-300' }}">{{ $item['score'] }}</td>
                    <td class="py-2 pl-4">
                        @foreach($item['reasons'] as $reason)
                            <span class="inline-block px-2 py-0.5 bg-white/5 rounded text-[10px] text-gray-400 mr-1 mb-1">{{ $reason }}</span>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
