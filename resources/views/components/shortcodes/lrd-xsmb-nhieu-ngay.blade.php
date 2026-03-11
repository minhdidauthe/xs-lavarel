<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-calendar-alt"></i> Kết Quả XSMB — {{ $limit }} Ngày Gần Nhất</h2>
    <div style="overflow-x:auto">
        <table class="sc-table" style="min-width:600px">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Giải ĐB</th>
                    <th>Lô (2 chữ số cuối)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $r)
                <tr>
                    <td style="white-space:nowrap">{{ $r->date->format('d/m/Y') }}</td>
                    <td>
                        @php $sp = $r->prizes['special'] ?? '---'; $sp = is_array($sp) ? ($sp[0] ?? '---') : $sp; @endphp
                        <span class="sc-badge sc-badge-hot">{{ $sp }}</span>
                    </td>
                    <td>
                        <div class="sc-nums" style="flex-wrap:wrap">
                            @foreach(array_slice($r->numbers ?? [], 0, 27) as $num)
                                <span class="sc-badge" style="font-size:11px">{{ str_pad(substr($num,-2),2,'0',STR_PAD_LEFT) }}</span>
                            @endforeach
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="sc-no-data">Chưa có dữ liệu.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
