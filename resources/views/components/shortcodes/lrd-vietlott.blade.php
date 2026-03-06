<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-ticket-alt"></i> {{ $title ?? 'Kết Quả Vietlott' }} — {{ $limit ?? 10 }} Kỳ Gần Nhất</h2>
    <table class="sc-table">
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Jackpot / Giá trị</th>
                <th>Số trúng</th>
            </tr>
        </thead>
        <tbody>
            @forelse($results as $r)
            <tr>
                <td style="white-space:nowrap">{{ $r->date instanceof \Carbon\Carbon ? $r->date->format('d/m/Y') : $r->date }}</td>
                <td>
                    @php
                        $jackpot = $r->prizes['jackpot'] ?? $r->prizes['jackpot1'] ?? $r->prizes['prize1'] ?? null;
                    @endphp
                    @if($jackpot)
                        <span style="color:#f59e0b; font-weight:bold">{{ is_numeric($jackpot) ? number_format($jackpot) . 'đ' : $jackpot }}</span>
                    @else
                        <span style="color:#666">—</span>
                    @endif
                </td>
                <td>
                    <div class="sc-nums" style="flex-wrap:wrap">
                        @foreach($r->numbers ?? [] as $num)
                            <span class="sc-badge sc-badge-hot" style="font-size:11px">{{ $num }}</span>
                        @endforeach
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="sc-no-data">Chưa có dữ liệu Vietlott.</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
