<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-moon"></i> Tra Cứu Số Mơ — Giải Mã Giấc Mơ
        </div>
        <div class="sc-tool-wrap">
            <div class="sc-tool-row">
                <input type="text" id="so-mo-input" class="sc-input" placeholder="Nhập từ khoá (vd: rắn, tiền, chó, mưa...)" style="flex:1" onkeydown="if(event.key==='Enter')traSoMo()">
                <button onclick="traSoMo()" class="sc-btn" style="background:#c0392b;color:#fff">Tra Cứu</button>
            </div>
            <div id="so-mo-result" style="margin-top:12px"></div>
            <div id="so-mo-popular" style="margin-top:16px">
                <p style="font-size:13px;color:#888;margin-bottom:8px"><i class="fas fa-star"></i> <strong>Giấc mơ phổ biến:</strong></p>
                <div style="display:flex;flex-wrap:wrap;gap:6px">
                    <span class="sc-badge" style="cursor:pointer" onclick="quickSearch('rắn')">🐍 Rắn</span>
                    <span class="sc-badge" style="cursor:pointer" onclick="quickSearch('chó')">🐕 Chó</span>
                    <span class="sc-badge" style="cursor:pointer" onclick="quickSearch('mèo')">🐱 Mèo</span>
                    <span class="sc-badge" style="cursor:pointer" onclick="quickSearch('cá')">🐟 Cá</span>
                    <span class="sc-badge" style="cursor:pointer" onclick="quickSearch('tiền')">💰 Tiền</span>
                    <span class="sc-badge" style="cursor:pointer" onclick="quickSearch('chết')">💀 Chết</span>
                    <span class="sc-badge" style="cursor:pointer" onclick="quickSearch('nước')">💧 Nước</span>
                    <span class="sc-badge" style="cursor:pointer" onclick="quickSearch('lửa')">🔥 Lửa</span>
                    <span class="sc-badge" style="cursor:pointer" onclick="quickSearch('đám cưới')">💒 Đám cưới</span>
                    <span class="sc-badge" style="cursor:pointer" onclick="quickSearch('nhà')">🏠 Nhà</span>
                    <span class="sc-badge" style="cursor:pointer" onclick="quickSearch('xe')">🚗 Xe</span>
                    <span class="sc-badge" style="cursor:pointer" onclick="quickSearch('mưa')">🌧 Mưa</span>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
const soMoDB = {
    // ── Động vật ──
    'ran': {nums:['12','21','51','15'], icon:'🐍', note:'Rắn là biểu tượng của sự thay đổi, nguy hiểm'},
    'con ran': {nums:['12','21','42','24'], icon:'🐍', note:'Con rắn lớn báo hiệu biến cố'},
    'cho': {nums:['10','01','16','61'], icon:'🐕', note:'Chó tượng trưng cho sự trung thành'},
    'con cho': {nums:['10','01','16','61'], icon:'🐕'},
    'meo': {nums:['02','20','35','53'], icon:'🐱', note:'Mèo gắn với sự khéo léo, bí ẩn'},
    'con meo': {nums:['02','20','35','53'], icon:'🐱'},
    'ca': {nums:['04','40','38','83'], icon:'🐟', note:'Cá là biểu tượng may mắn, tài lộc'},
    'con ca': {nums:['04','40','38','83'], icon:'🐟'},
    'ga': {nums:['03','30','33','39'], icon:'🐓', note:'Gà trống báo thức, khởi đầu mới'},
    'con ga': {nums:['03','30','39','93'], icon:'🐓'},
    'trau': {nums:['14','41','31','13'], icon:'🐃', note:'Trâu tượng trưng cho sức mạnh'},
    'bo': {nums:['14','41','32','23'], icon:'🐂', note:'Bò là biểu tượng của sự kiên nhẫn'},
    'ngua': {nums:['06','60','36','63'], icon:'🐴', note:'Ngựa biểu tượng tự do, tốc độ'},
    'de': {nums:['07','70','37','73'], icon:'🐐', note:'Dê gắn với sự hiền lành'},
    'khi': {nums:['08','80','48','84'], icon:'🐒', note:'Khỉ tượng trưng cho sự nhanh nhẹn'},
    'heo': {nums:['09','90','49','94'], icon:'🐷', note:'Heo là phú quý, sung túc'},
    'lon': {nums:['09','90','49','94'], icon:'🐷'},
    'cop': {nums:['05','50','55','25'], icon:'🐯', note:'Cọp là quyền lực, dũng mãnh'},
    'ho': {nums:['05','50','55','25'], icon:'🐯'},
    'rong': {nums:['11','88','18','81'], icon:'🐉', note:'Rồng là biểu tượng quyền quý'},
    'chuot': {nums:['01','10','31','13'], icon:'🐀', note:'Chuột gắn với sự lanh lợi'},
    'tho': {nums:['07','70','47','74'], icon:'🐇', note:'Thỏ là hiền lành, may mắn'},
    'chim': {nums:['72','27','57','75'], icon:'🐦', note:'Chim bay cao, tự do'},
    'buom': {nums:['62','26','67','76'], icon:'🦋', note:'Bướm là sự biến đổi tốt đẹp'},
    'ong': {nums:['79','97','29','92'], icon:'🐝', note:'Ong chăm chỉ, ngọt ngào'},
    'voi': {nums:['45','54','15','51'], icon:'🐘', note:'Voi tượng trưng sức mạnh, trí tuệ'},
    'kien': {nums:['64','46','34','43'], icon:'🐜', note:'Kiến là sự chăm chỉ'},
    'tom': {nums:['58','85','48','84'], icon:'🦐', note:'Tôm biểu tượng dồi dào'},
    'cua': {nums:['56','65','46','64'], icon:'🦀', note:'Cua là sự bám trụ'},
    'ech': {nums:['78','87','28','82'], icon:'🐸', note:'Ếch kêu trước mưa, điềm lành'},
    'sau': {nums:['69','96','39','93'], icon:'🐛', note:'Sâu là biến đổi, chuyển mình'},
    'ruoi': {nums:['89','98','19','91'], icon:'🪰', note:'Ruồi báo hiệu phiền toái'},
    'muoi': {nums:['59','95','29','92'], icon:'🦟'},
    'oc': {nums:['66','06','60','16'], icon:'🐌'},
    'dai bang': {nums:['71','17','77','27'], icon:'🦅', note:'Đại bàng bay cao, thành đạt'},
    'ca sau': {nums:['52','25','42','24'], icon:'🐊', note:'Cá sấu là nguy hiểm rình rập'},

    // ── Con người, quan hệ ──
    'nguoi than': {nums:['41','14','44','11'], icon:'👨‍👩‍👧', note:'Người thân là tình cảm gia đình'},
    'me': {nums:['11','44','41','14'], icon:'👩', note:'Mẹ là tình yêu vô bờ'},
    'ba': {nums:['44','11','14','41'], icon:'👨', note:'Cha/ba là trụ cột gia đình'},
    'cha': {nums:['44','11','14','41'], icon:'👨'},
    'con': {nums:['22','33','23','32'], icon:'👶', note:'Con cái là hạnh phúc'},
    'vo': {nums:['34','43','03','30'], icon:'👩‍❤️‍👨', note:'Vợ là hạnh phúc gia đình'},
    'chong': {nums:['43','34','30','03'], icon:'👨‍❤️‍👩'},
    'ban be': {nums:['68','86','36','63'], icon:'🤝', note:'Bạn bè là tình nghĩa'},
    'nguoi yeu': {nums:['69','96','79','97'], icon:'❤️', note:'Người yêu là tình cảm mãnh liệt'},
    'em be': {nums:['22','33','02','20'], icon:'👶'},
    'ong gia': {nums:['45','54','05','50'], icon:'👴'},
    'ba gia': {nums:['54','45','50','05'], icon:'👵'},
    'dam cuoi': {nums:['36','63','23','32'], icon:'💒', note:'Đám cưới là niềm vui, hạnh phúc'},
    'cuoi': {nums:['36','63','23','32'], icon:'💒'},
    'dam tang': {nums:['53','35','05','50'], icon:'⚰️', note:'Đám tang là kết thúc, khởi đầu mới'},
    'dam ma': {nums:['53','35','50','05'], icon:'⚰️'},

    // ── Hiện tượng, sự kiện ──
    'tien': {nums:['00','11','68','86'], icon:'💰', note:'Tiền bạc là may mắn, tài lộc'},
    'vang': {nums:['68','86','88','00'], icon:'🥇', note:'Vàng là phú quý, giàu sang'},
    'trung so': {nums:['00','11','88','99'], icon:'🎰', note:'Trúng số là điềm lành'},
    'chet': {nums:['05','50','53','35'], icon:'💀', note:'Chết trong mơ thường là điềm đổi mới'},
    'lua': {nums:['33','77','47','74'], icon:'🔥', note:'Lửa cháy là đam mê, biến động'},
    'chay': {nums:['33','77','47','74'], icon:'🔥'},
    'nuoc': {nums:['26','62','18','81'], icon:'💧', note:'Nước là tài lộc, cuốn trôi phiền muộn'},
    'mua': {nums:['26','62','76','67'], icon:'🌧', note:'Mưa mang đến sự tươi mới'},
    'bao': {nums:['37','73','57','75'], icon:'🌪', note:'Bão tố là biến cố lớn'},
    'dong dat': {nums:['99','00','55','45'], icon:'🌋', note:'Động đất báo thay đổi đột ngột'},
    'sam set': {nums:['33','77','37','73'], icon:'⚡'},
    'nha': {nums:['44','09','90','19'], icon:'🏠', note:'Nhà là sự ổn định, an cư'},
    'xe': {nums:['17','71','55','51'], icon:'🚗', note:'Xe là hành trình, di chuyển'},
    'may bay': {nums:['72','27','62','26'], icon:'✈️', note:'Máy bay là thăng tiến, bay cao'},
    'bay': {nums:['72','27','62','26'], icon:'🕊', note:'Bay là tự do, giải thoát'},
    'tau': {nums:['58','85','18','81'], icon:'🚢', note:'Tàu là hành trình dài'},
    'boi': {nums:['67','76','38','83'], icon:'🏊'},
    'an com': {nums:['43','34','03','30'], icon:'🍚'},
    'an': {nums:['43','34','03','30'], icon:'🍽'},
    'ngu': {nums:['22','77','27','72'], icon:'😴'},
    'khoc': {nums:['36','63','56','65'], icon:'😢', note:'Khóc trong mơ thường là điềm vui'},
    'cuoi': {nums:['23','32','63','36'], icon:'😄'},

    // ── Đồ vật, thiên nhiên ──
    'cay': {nums:['39','93','29','92'], icon:'🌳', note:'Cây cối là sức sống, phát triển'},
    'hoa': {nums:['69','96','79','97'], icon:'🌸', note:'Hoa là vẻ đẹp, may mắn'},
    'trang': {nums:['22','77','27','72'], icon:'🌙', note:'Trăng sáng là thanh bình'},
    'mat troi': {nums:['11','88','18','81'], icon:'☀️', note:'Mặt trời là thành công rực rỡ'},
    'sao': {nums:['55','00','50','05'], icon:'⭐', note:'Sao sáng là hy vọng'},
    'nui': {nums:['45','54','15','51'], icon:'🏔', note:'Núi là vững chắc, khó khăn'},
    'bien': {nums:['76','67','16','61'], icon:'🌊', note:'Biển cả là bao la, tự do'},
    'song': {nums:['26','62','36','63'], icon:'🏞', note:'Sông là dòng chảy cuộc đời'},
    'dao': {nums:['46','64','56','65'], icon:'🏝'},
    'ruong': {nums:['29','92','39','93'], icon:'🌾', note:'Ruộng đồng là no đủ'},
    'kim cuong': {nums:['99','88','98','89'], icon:'💎', note:'Kim cương là quý giá'},
    'nhan': {nums:['69','96','99','66'], icon:'💍', note:'Nhẫn là gắn kết, hứa hẹn'},
    'guong': {nums:['78','87','08','80'], icon:'🪞', note:'Gương là soi lại bản thân'},
    'dao': {nums:['57','75','17','71'], icon:'🔪', note:'Dao/kiếm là xung đột'},
    'chia khoa': {nums:['48','84','38','83'], icon:'🔑', note:'Chìa khoá mở cơ hội mới'},
    'sach': {nums:['42','24','82','28'], icon:'📚', note:'Sách là trí tuệ, học hỏi'},
    'dien thoai': {nums:['37','73','07','70'], icon:'📱', note:'Điện thoại là tin tức'},
    'quan ao': {nums:['47','74','17','71'], icon:'👔'},
    'giay': {nums:['52','25','02','20'], icon:'👟'},

    // ── Nơi chốn ──
    'chua': {nums:['22','77','72','27'], icon:'🛕', note:'Chùa là bình an, tâm linh'},
    'benh vien': {nums:['53','35','03','30'], icon:'🏥', note:'Bệnh viện cần lưu ý sức khoẻ'},
    'truong hoc': {nums:['42','24','82','28'], icon:'🏫'},
    'cho': {nums:['43','34','13','31'], icon:'🏪', note:'Chợ là giao thương, tấp nập'},
    'nghia dia': {nums:['05','50','55','15'], icon:'🪦', note:'Nghĩa địa là quá khứ, nhớ nhung'},

    // ── Hành động ──
    'danh nhau': {nums:['57','75','37','73'], icon:'👊', note:'Đánh nhau là xung đột'},
    'chay tron': {nums:['66','06','60','16'], icon:'🏃', note:'Chạy trốn là lo lắng'},
    'roi': {nums:['08','80','58','85'], icon:'😱', note:'Rơi/ngã là mất kiểm soát'},
    'nga': {nums:['08','80','58','85'], icon:'😱'},
    'leo nui': {nums:['45','54','95','59'], icon:'🧗', note:'Leo núi là vượt khó'},
    'hat': {nums:['69','96','39','93'], icon:'🎤'},
    'nhay': {nums:['62','26','72','27'], icon:'💃'},
    'lai xe': {nums:['17','71','55','15'], icon:'🚗'},
    'nau an': {nums:['43','34','83','38'], icon:'👩‍🍳'},
    'cau ca': {nums:['04','40','84','48'], icon:'🎣', note:'Câu cá là kiên nhẫn chờ đợi'},
    'danh bai': {nums:['86','68','88','66'], icon:'🃏', note:'Đánh bài là may rủi'},

    // ── Trạng thái, cảm xúc ──
    'so': {nums:['08','80','58','85'], icon:'😨', note:'Sợ hãi cần bình tĩnh'},
    'vui': {nums:['23','32','63','36'], icon:'😊', note:'Vui vẻ là điềm tốt'},
    'buon': {nums:['56','65','36','63'], icon:'😢', note:'Buồn rồi sẽ qua'},
    'gian': {nums:['57','75','37','73'], icon:'😠'},
    'yeu': {nums:['69','96','79','97'], icon:'❤️', note:'Tình yêu là hạnh phúc'},
    'mat': {nums:['08','80','18','81'], icon:'😰', note:'Mất mát cần cẩn trọng'},
    'duoc': {nums:['68','86','88','00'], icon:'🎁', note:'Được nhận là may mắn'},
    'thang': {nums:['11','88','18','81'], icon:'🏆', note:'Chiến thắng rực rỡ'},
    'thua': {nums:['05','50','55','15'], icon:'😞'},
};

function removeVietnamese(str) {
    return str.normalize('NFD').replace(/[\u0300-\u036f]/g,'')
              .replace(/đ/g,'d').replace(/Đ/g,'D').toLowerCase().trim();
}

function hashStr(s) {
    let h = 0;
    for (let i = 0; i < s.length; i++) h = ((h << 5) - h + s.charCodeAt(i)) | 0;
    return Math.abs(h);
}

function generateNums(kw) {
    const h = hashStr(kw);
    const nums = new Set();
    // Sinh 4 số từ hash, mỗi lần xoay seed
    let seed = h;
    while (nums.size < 4) {
        seed = (seed * 1103515245 + 12345) & 0x7fffffff;
        nums.add(String(seed % 100).padStart(2, '0'));
    }
    return [...nums];
}

function quickSearch(kw) {
    document.getElementById('so-mo-input').value = kw;
    traSoMo();
}

function traSoMo() {
    const raw = document.getElementById('so-mo-input').value.trim();
    const el  = document.getElementById('so-mo-result');
    if (!raw) { el.innerHTML = '<span style="color:red">Vui lòng nhập từ khoá</span>'; return; }

    const kw = removeVietnamese(raw);
    let found = null;
    let bestLen = 0;

    // Tìm match dài nhất (ưu tiên match chính xác hơn)
    for (const [key, data] of Object.entries(soMoDB)) {
        if (kw === key || kw.includes(key) || key.includes(kw)) {
            const matchLen = key.length;
            if (matchLen > bestLen) {
                bestLen = matchLen;
                found = {key, ...data};
            }
        }
    }

    if (found) {
        el.innerHTML = `
            <div style="background:#fff8e1;border:1px solid #ffe082;border-radius:10px;padding:14px">
                <div style="font-size:16px;margin-bottom:8px">${found.icon || '🔮'} Mơ thấy <strong>"${raw}"</strong></div>
                ${found.note ? `<p style="color:#666;font-size:13px;margin:4px 0 10px">${found.note}</p>` : ''}
                <div style="font-weight:600;margin-bottom:6px">→ Nên đánh số:</div>
                <div class="sc-nums" style="gap:8px;flex-wrap:wrap">
                    ${found.nums.map(n => `<span class="sc-badge sc-badge-hot" style="font-size:16px;min-width:40px">${n}</span>`).join('')}
                </div>
            </div>`;
    } else {
        // Fallback: sinh số từ keyword bằng thuật toán hash
        const nums = generateNums(kw);
        el.innerHTML = `
            <div style="background:#e8f5e9;border:1px solid #a5d6a7;border-radius:10px;padding:14px">
                <div style="font-size:16px;margin-bottom:8px">🔮 Giải mã <strong>"${raw}"</strong></div>
                <p style="color:#666;font-size:13px;margin:4px 0 10px">Số may mắn gợi ý theo phân tích từ khoá</p>
                <div style="font-weight:600;margin-bottom:6px">→ Số gợi ý:</div>
                <div class="sc-nums" style="gap:8px;flex-wrap:wrap">
                    ${nums.map(n => `<span class="sc-badge sc-badge-hot" style="font-size:16px;min-width:40px">${n}</span>`).join('')}
                </div>
            </div>`;
    }

    // Ẩn popular tags sau khi search
    const pop = document.getElementById('so-mo-popular');
    if (pop) pop.style.display = 'none';
}
</script>
