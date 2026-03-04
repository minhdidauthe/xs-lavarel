<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-table-list"></i>
            Bạch Thủ Lô Nuôi Khung {{ $days }} Ngày - Cập nhật {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        @if($bachThu)
        <p class="sc-khung-intro">
            <i class="fas fa-circle-dot"></i> Số nuôi: <strong class="green">{{ $bachThu }}</strong>
            &nbsp;—&nbsp; Nuôi trong {{ $days }} ngày liên tiếp
        </p>
        @endif
        <div class="sc-table-wrap">
            <table class="sc-khung-table">
                <thead>
                    <tr>
                        <th class="sc-khung-th-date">Ngày</th>
                        <th>Số nuôi</th>
                        <th>Kết quả</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($khungData as $row)
                    <tr class="{{ $row['status'] === 've' ? 'sc-row-ve' : ($row['status'] === 'khong_ve' ? 'sc-row-khongve' : 'sc-row-cho') }}">
                        <td class="sc-khung-td-date"><strong>{{ $row['date'] }}</strong></td>
                        <td class="sc-khung-td-so">
                            <span class="sc-num-badge {{ $row['status'] === 've' ? 'green' : '' }}">
                                {{ $row['so_nuoi'] ?? '--' }}
                            </span>
                        </td>
                        <td class="sc-khung-td-kq">
                            @if($row['status'] === 've')
                                <span class="sc-kq-ve"><i class="fas fa-check-circle"></i> Về rồi ✓</span>
                            @elseif($row['status'] === 'khong_ve')
                                <span class="sc-kq-khongve"><i class="fas fa-xmark-circle"></i> Không về ✗</span>
                            @else
                                <span class="sc-kq-cho"><i class="fas fa-clock"></i> Đang chờ kết quả...</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="sc-no-data">Chưa có dữ liệu</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Lưu ý: Con số chỉ dùng cho mục đích tham khảo. Chúc bạn may mắn!</em>
        </div>
    </div>
</section>
