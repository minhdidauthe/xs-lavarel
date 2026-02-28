@if(count($loTop ?? []) > 0)
<section class="container sc-section">
    <div class="sc-lotop-box">
        <h2 class="sc-lotop-title"><i class="fas fa-trophy"></i> Bảng lô top chơi nhiều</h2>
        <div class="sc-lotop-tabs">
            <span class="sc-lotop-tab active" data-tab="today">Hôm nay</span>
            <span class="sc-lotop-tab" data-tab="yesterday">Hôm qua</span>
            <span class="sc-lotop-tab" data-tab="daybefore">Hôm kia</span>
        </div>

        <div class="sc-lotop-panel" data-panel="today">
            <p class="sc-lotop-date">Bảng lô top ngày {{ $dates[0] ?? now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}</p>
            <div class="sc-lotop-numbers">
                @foreach($loTop as $num)
                    <span class="sc-lotop-num">{{ $num }}</span>
                @endforeach
            </div>
        </div>

        <div class="sc-lotop-panel" data-panel="yesterday" style="display:none">
            <p class="sc-lotop-date">Bảng lô top ngày {{ $dates[1] ?? '' }}</p>
            <div class="sc-lotop-numbers">
                @forelse($loTopYesterday ?? [] as $num)
                    <span class="sc-lotop-num">{{ $num }}</span>
                @empty
                    <span style="color:#999">Chưa có dữ liệu</span>
                @endforelse
            </div>
        </div>

        <div class="sc-lotop-panel" data-panel="daybefore" style="display:none">
            <p class="sc-lotop-date">Bảng lô top ngày {{ $dates[2] ?? '' }}</p>
            <div class="sc-lotop-numbers">
                @forelse($loTopDayBefore ?? [] as $num)
                    <span class="sc-lotop-num">{{ $num }}</span>
                @empty
                    <span style="color:#999">Chưa có dữ liệu</span>
                @endforelse
            </div>
        </div>

        <div style="text-align:center; margin-top:12px;">
            <a href="/thong-ke" class="sc-btn-more red">Xem đầy đủ <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>
<script>
document.querySelectorAll('.sc-lotop-tab').forEach(function(tab) {
    tab.addEventListener('click', function() {
        var box = this.closest('.sc-lotop-box');
        box.querySelectorAll('.sc-lotop-tab').forEach(function(t) { t.classList.remove('active'); });
        box.querySelectorAll('.sc-lotop-panel').forEach(function(p) { p.style.display = 'none'; });
        this.classList.add('active');
        var panel = box.querySelector('[data-panel="' + this.dataset.tab + '"]');
        if (panel) panel.style.display = '';
    });
});
</script>
@endif
