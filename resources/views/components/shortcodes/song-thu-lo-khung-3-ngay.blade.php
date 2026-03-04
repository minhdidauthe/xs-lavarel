<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-table-list"></i>
            Song Thủ Lô Nuôi Khung 3 Ngày - Cập nhật {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <div class="sc-table-wrap sc-table-responsive">
            <table class="sc-khung-table sc-stl3-table">
                <thead>
                    <tr>
                        <th class="sc-stl3-th-date">Ngày</th>
                        <th class="sc-stl3-th-nums">Song Thủ Lô Khung 3 Ngày</th>
                        <th class="sc-stl3-th-kq">Kết Quả</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($khungData as $row)
                    <tr class="{{ $row['status'] === 've' ? 'sc-row-ve' : ($row['status'] === 'khong_ve' ? 'sc-row-khongve' : 'sc-row-cho') }}{{ $row['is_current'] ? ' sc-row-current' : '' }}">
                        <td class="sc-khung-td-date sc-stl3-td-date">
                            <strong>{{ $row['date_range'] }}</strong>
                        </td>
                        <td class="sc-stl3-td-nums">
                            <span class="sc-stl3-badge">{{ $row['so1'] }} – {{ $row['dao1'] }}</span>
                        </td>
                        <td class="sc-stl3-td-kq">
                            @if($row['status'] === 'cho')
                                <span class="sc-kq-cho"><i class="fas fa-clock"></i> Trúng: đang chờ</span>
                            @else
                                <span class="{{ !empty($row['trung']) ? 'sc-kq-ve' : 'sc-kq-khongve' }}">
                                    Trúng: {{ !empty($row['trung']) ? implode(', ', $row['trung']) : '' }}
                                </span>
                                @if(!empty($row['truot']))
                                <br><span class="sc-kq-khongve">Trượt: {{ implode(', ', $row['truot']) }}</span>
                                @endif
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
            <i class="fas fa-info-circle"></i> <em>Mỗi hàng = 1 khung 3 ngày liên tiếp. Số thay đổi theo từng khung. Chỉ mang tính tham khảo.</em>
        </div>
    </div>
</section>
