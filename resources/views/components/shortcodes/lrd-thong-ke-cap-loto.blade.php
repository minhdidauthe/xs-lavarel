<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-link"></i> Thống Kê Cặp Loto Hay Ra {{ $region }} — {{ $days }} Ngày Gần Nhất
        </div>
        <table class="sc-table">
            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Cặp số</th>
                    <th>Số lần cùng xuất hiện</th>
                </tr>
            </thead>
            <tbody>
                @php $rank = 0; @endphp
                @forelse($topCap as $cap => $count)
                @php
                    $rank++;
                    $parts = explode('-', $cap);
                @endphp
                <tr>
                    <td><strong>{{ $rank }}</strong></td>
                    <td>
                        <span class="sc-badge sc-badge-hot" style="font-size:13px">{{ $parts[0] ?? '' }}</span>
                        <span style="margin:0 2px">—</span>
                        <span class="sc-badge sc-badge-hot" style="font-size:13px">{{ $parts[1] ?? '' }}</span>
                    </td>
                    <td><strong>{{ $count }}</strong> lần</td>
                </tr>
                @empty
                <tr><td colspan="3" class="sc-no-data">Chưa có dữ liệu.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Top {{ count($topCap) }} cặp loto xuất hiện cùng ngày nhiều nhất trong {{ $days }} ngày qua ({{ $region }}).</em>
        </div>
    </div>
</section>
