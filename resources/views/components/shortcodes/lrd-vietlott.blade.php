<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-ticket-alt"></i> {{ $title ?? 'Kết Quả Vietlott' }}
        </div>
        <table class="sc-table">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Số trúng</th>
                    @if(($type ?? '') === 'power655')
                    <th>Số PB</th>
                    @endif
                    <th>Jackpot</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $r)
                <tr>
                    <td style="white-space:nowrap">{{ $r['date'] }}</td>
                    <td>
                        <div class="sc-nums" style="flex-wrap:wrap;gap:4px">
                            @foreach($r['numbers'] ?? [] as $num)
                                <span class="sc-badge sc-badge-hot" style="font-size:13px;min-width:32px">{{ $num }}</span>
                            @endforeach
                        </div>
                    </td>
                    @if(($type ?? '') === 'power655')
                    <td>
                        @if(!empty($r['extra']))
                            <span class="sc-badge sc-badge-kep" style="font-size:13px">{{ $r['extra'] }}</span>
                        @else
                            —
                        @endif
                    </td>
                    @endif
                    <td><span style="color:#f59e0b;font-weight:600;font-size:12px">{{ $r['jackpot'] ?? '—' }}</span></td>
                </tr>
                @empty
                <tr><td colspan="{{ ($type ?? '') === 'power655' ? 4 : 3 }}" class="sc-no-data">Chưa có dữ liệu.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> <em>Kết quả {{ $title ?? 'Vietlott' }} gần nhất. Dữ liệu chỉ mang tính tham khảo.</em></div>
    </div>
</section>
