<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-random"></i> Quay Thử Xổ Số {{ $region ?? 'MB' }}
        </div>
        <div style="text-align:center; margin:16px 0">
            <button onclick="qt_simple()" class="sc-btn" style="font-size:1rem; padding:10px 28px">
                <i class="fas fa-dice"></i> Quay Ngay
            </button>
        </div>
        <div id="qt-simple-result" class="sc-nums" style="justify-content:center; flex-wrap:wrap; min-height:50px; margin-top:12px">
            <span style="color:#aaa; font-size:13px">Nhấn quay để xem kết quả</span>
        </div>
    </div>
</section>
<script>
function qt_simple() {
    const el = document.getElementById('qt-simple-result');
    el.innerHTML = '<span style="color:#aaa">Đang quay...</span>';
    setTimeout(() => {
        const count = 18;
        const nums = new Set();
        while (nums.size < count) nums.add(Math.floor(Math.random()*100).toString().padStart(2,'0'));
        el.innerHTML = [...nums].map(n=>`<span class="sc-badge">${n}</span>`).join('');
    }, 500);
}
</script>
