<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-table-list"></i>
            Song Thủ Lô Nuôi Khung 3 Ngày - Cập nhật {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <div class="sc-table-wrap sc-table-responsive">
            <table class="sc-khung-table sc-stl-khung-table">
                <thead>
                    <tr>
                        <th class="sc-khung-th-date">Khung ngày</th>
                        @foreach($khungData[0]['pairs'] ?? [['so'=>'Số 1','dao'=>null],['so'=>'Số 2','dao'=>null]] as $p)
                        <th>{{ $p['so'] }}{{ $p['dao'] ? ' ↔ '.$p['dao'] : '' }}</th>
                        @endforeach
                        <th>Kết quả 3 ngày</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($khungData as $row)
                    <tr class="{{ $row['status'] === 've' ? 'sc-row-ve' : ($row['status'] === 'khong_ve' ? 'sc-row-khongve' : 'sc-row-cho') }}{{ $row['is_current'] ? ' sc-row-current' : '' }}">
                        <td class="sc-khung-td-date">
                            <strong>{{ $row['date_range'] }}</strong>
                            @if($row['is_current'])<span class="sc-khung-now">Hiện tại</span>@endif
                        </td>
                        @foreach($row['pairs'] as $p)
                        <td class="sc-khung-td-so">
                            <span class="sc-stl-num-sm {{ $p['hit'] ?? false ? 'green' : '' }}">{{ $p['so'] }}</span>
                            @if($p['dao'])
                            <span class="sc-stl-sep-sm">↔</span>
                            <span class="sc-stl-num-sm blue">{{ $p['dao'] }}</span>
                            @endif
                        </td>
                        @endforeach
                        <td class="sc-khung-td-kq">
                            @if($row['status'] === 've')
                                <span class="sc-kq-ve"><i class="fas fa-check-circle"></i> Về ✓</span>
                            @elseif($row['status'] === 'khong_ve')
                                <span class="sc-kq-khongve"><i class="fas fa-xmark-circle"></i> Không về ✗</span>
                            @else
                                <span class="sc-kq-cho"><i class="fas fa-clock"></i> Đang chờ...</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="sc-no-data">Chưa có dữ liệu</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Mỗi hàng = 1 khung 3 ngày liên tiếp. Chỉ mang tính tham khảo.</em>
        </div>
    </div>
</section>
