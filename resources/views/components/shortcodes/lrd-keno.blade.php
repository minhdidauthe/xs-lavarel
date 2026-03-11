<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-dice"></i> Kết Quả Keno — {{ $limit }} Kỳ Gần Nhất
        </div>
        <table class="sc-table">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>20 Số Trúng</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $r)
                <tr>
                    <td style="white-space:nowrap">{{ $r['date'] }}</td>
                    <td>
                        <div class="sc-nums" style="flex-wrap:wrap;gap:3px">
                            @foreach($r['numbers'] ?? [] as $num)
                                <span class="sc-badge" style="font-size:11px;min-width:28px">{{ $num }}</span>
                            @endforeach
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="2" class="sc-no-data">Chưa có dữ liệu Keno.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> <em>Kết quả Keno gần nhất. Dữ liệu chỉ mang tính tham khảo.</em></div>
    </div>
</section>
