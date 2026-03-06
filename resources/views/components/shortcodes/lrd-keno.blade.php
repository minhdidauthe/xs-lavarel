<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-dice"></i> Kết Quả Keno — {{ $limit }} Kỳ Gần Nhất</h2>
    <table class="sc-table">
        <thead>
            <tr>
                <th>Kỳ / Ngày</th>
                <th>Số trúng</th>
            </tr>
        </thead>
        <tbody>
            @forelse($results as $r)
            <tr>
                <td style="white-space:nowrap">{{ $r->date instanceof \Carbon\Carbon ? $r->date->format('d/m/Y') : $r->date }}</td>
                <td>
                    <div class="sc-nums" style="flex-wrap:wrap">
                        @foreach($r->numbers ?? [] as $num)
                            <span class="sc-badge" style="font-size:11px">{{ $num }}</span>
                        @endforeach
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="2" class="sc-no-data">Chưa có dữ liệu Keno.</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
