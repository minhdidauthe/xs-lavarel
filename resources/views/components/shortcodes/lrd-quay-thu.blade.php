<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-redo-alt"></i> Quay Thử Xổ Số {{ $region }} {{ $province ? "— $province" : '' }}
        </div>
        <p style="color:#aaa; text-align:center; font-size:13px">Mô phỏng quay thử — kết quả ngẫu nhiên mỗi lần nhấn</p>
        <div style="text-align:center; margin:16px 0">
            <button onclick="quaythu({{ $hard ? 'true' : 'false' }})" class="sc-btn" style="font-size:1rem; padding:10px 28px">
                <i class="fas fa-play"></i> Quay Thử
            </button>
        </div>
        <div id="qt-result" class="sc-nums" style="justify-content:center; flex-wrap:wrap; min-height:50px; margin-top:12px"></div>
    </div>
</section>
<script>
function quaythu(hard) {
    const el = document.getElementById('qt-result');
    el.innerHTML = '<span style="color:#aaa">Đang quay...</span>';
    setTimeout(() => {
        const count = hard ? 27 : 18;
        const nums = new Set();
        while (nums.size < count) nums.add(Math.floor(Math.random()*100).toString().padStart(2,'0'));
        el.innerHTML = [...nums].map(n=>`<span class="sc-badge">${n}</span>`).join('');
    }, 600);
}
</script>
