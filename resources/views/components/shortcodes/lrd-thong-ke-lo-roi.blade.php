<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-exclamation-triangle"></i> Lô Rơi / Ít Về Nhất {{ $region }} — {{ $days }} Ngày
        </div>
        <table class="sc-table">
            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Số lô</th>
                    <th>Số ngày chưa về (gan)</th>
                    <th>Nhận định</th>
                </tr>
            </thead>
            <tbody>
                @php $rank = 0; @endphp
                @forelse($loRoi as $num => $ganDays)
                @php $rank++; @endphp
                <tr>
                    <td><strong>{{ $rank }}</strong></td>
                    <td><span class="sc-badge sc-badge-cold" style="font-size:14px">{{ $num }}</span></td>
                    <td>
                        @if($ganDays > $days)
                            <strong style="color:#dc3545">{{ $ganDays }}+ ngày</strong> <small>(chưa về trong {{ $days }} ngày)</small>
                        @else
                            <strong style="color:#e67e22">{{ $ganDays }} ngày</strong>
                        @endif
                    </td>
                    <td>
                        @if($ganDays > $days)
                            <span class="sc-kq-khongve"><i class="fas fa-fire"></i> Rất lâu chưa về</span>
                        @elseif($ganDays >= 20)
                            <span class="sc-kq-khongve">Lâu chưa về</span>
                        @elseif($ganDays >= 10)
                            <span class="sc-kq-cho">Khá lâu</span>
                        @else
                            <span class="sc-kq-ve">Mới gan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="sc-no-data">Không có dữ liệu.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Top {{ count($loRoi) }} con lô lâu chưa về nhất trong {{ $days }} ngày qua ({{ $region }}).</em>
        </div>
    </div>
</section>
