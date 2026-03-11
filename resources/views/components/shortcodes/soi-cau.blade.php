<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-brain"></i> Soi Cầu AI — Top 10
            <span style="font-size:11px; font-weight:400; margin-left:10px">{{ $prediction['details']['predict_date'] ?? date('d/m/Y') }}</span>
        </div>
        {{-- Top 3 highlight --}}
        <div style="display:flex; flex-wrap:wrap; gap:12px; justify-content:center; padding:16px 10px 8px">
            @foreach(array_slice($prediction['top10'], 0, 3) as $idx => $item)
            <div style="text-align:center">
                <span class="sc-num-ball {{ ['red','green','orange'][$idx] ?? 'red' }}" style="width:52px; height:52px; font-size:18px; line-height:52px">{{ $item['number'] }}</span>
                <p style="font-size:10px; color:#2e8b57; font-weight:700; margin-top:4px">{{ $item['score'] }}</p>
            </div>
            @endforeach
        </div>
        {{-- Full table --}}
        <table class="sc-stats-table" style="margin-top:4px">
            <thead>
                <tr>
                    <th style="width:30px">#</th>
                    <th style="width:50px">Số</th>
                    <th style="width:60px">Điểm</th>
                    <th style="text-align:left; padding-left:12px">Lý do</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prediction['top10'] as $idx => $item)
                <tr style="{{ $idx < 3 ? 'background:#fffef0' : '' }}">
                    <td style="font-weight:700; {{ $idx < 3 ? 'color:#e67e22' : 'color:#999' }}">{{ $idx + 1 }}</td>
                    <td><span class="sc-badge {{ $idx < 3 ? 'sc-badge-hot' : '' }}">{{ $item['number'] }}</span></td>
                    <td style="font-weight:700; {{ $idx < 3 ? 'color:#e67e22' : '' }}">{{ $item['score'] }}</td>
                    <td style="text-align:left; padding-left:12px">
                        @foreach($item['reasons'] as $reason)
                            <span style="display:inline-block; padding:1px 6px; background:#f0f0f0; border-radius:3px; font-size:10px; color:#666; margin:1px 2px">{{ $reason }}</span>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
