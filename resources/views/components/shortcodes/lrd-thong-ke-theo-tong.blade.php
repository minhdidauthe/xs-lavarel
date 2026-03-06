<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-sigma"></i> Thống Kê Theo Tổng Số {{ $region }} — {{ $days }} Ngày</h2>
    <p class="sc-subtitle">Tổng 2 chữ số cuối của lô về (tổng từ 0–18)</p>
    <table class="sc-table">
        <thead><tr><th>Tổng</th><th>Lần về</th><th>Ví dụ</th></tr></thead>
        <tbody>
            @forelse($tongFreq as $tong => $count)
            @php
                $ex = [];
                for ($d=0; $d<=9 && count($ex)<2; $d++) {
                    $u = $tong - $d;
                    if ($u >= 0 && $u <= 9) $ex[] = str_pad($d,1).''.str_pad($u,1);
                }
            @endphp
            <tr>
                <td><strong class="sc-tong">{{ $tong }}</strong></td>
                <td>{{ $count }} lần</td>
                <td class="sc-muted">{{ implode(', ', $ex) }}...</td>
            </tr>
            @empty
            <tr><td colspan="3" class="sc-no-data">Chưa có dữ liệu.</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
