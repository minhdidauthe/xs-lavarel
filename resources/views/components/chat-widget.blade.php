{{-- Chatbot Widget --}}
<button class="cb-float-btn" id="cbFloatBtn" aria-label="Mở chat">
    <i class="fas fa-comments"></i>
    <span class="cb-badge" id="cbBadge" style="display:none">0</span>
</button>

<div class="cb-window" id="cbWindow" style="display:none">
    <div class="cb-header">
        <div class="cb-header-left">
            <div class="cb-avatar-bot"><i class="fas fa-robot"></i></div>
            <div>
                <div class="cb-title">Soi Cầu 7777</div>
                <div class="cb-online">
                    <span class="cb-online-dot"></span>
                    <span id="cbOnline">0</span> người đang online
                </div>
            </div>
        </div>
        <button class="cb-close" id="cbCloseBtn"><i class="fas fa-times"></i></button>
    </div>

    <div class="cb-messages" id="cbMessages">
        <div class="cb-system-msg">
            Chào mừng bạn đến phòng chat Soi Cầu 7777! Chia sẻ dự đoán và thảo luận cùng cộng đồng.
        </div>
    </div>

    <div class="cb-input-area">
        <div id="cbNameArea" class="cb-name-input">
            <input type="text" id="cbNameInput" placeholder="Nhập tên hiển thị..." maxlength="50">
            <button id="cbNameBtn"><i class="fas fa-arrow-right"></i></button>
        </div>
        <div id="cbChatArea" class="cb-chat-input" style="display:none">
            <input type="text" id="cbMsgInput" placeholder="Nhập tin nhắn..." maxlength="500">
            <button id="cbSendBtn"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>
</div>

<script>
(function() {
    const SITE = 'soicau7777';
    const API = '/api/chat';
    let username = localStorage.getItem('chat_username') || '';
    let isOpen = false;
    let unread = 0;
    let pollTimer = null;

    const $ = id => document.getElementById(id);
    const floatBtn = $('cbFloatBtn');
    const window_ = $('cbWindow');
    const badge = $('cbBadge');
    const msgContainer = $('cbMessages');
    const nameArea = $('cbNameArea');
    const chatArea = $('cbChatArea');
    const nameInput = $('cbNameInput');
    const msgInput = $('cbMsgInput');
    const onlineEl = $('cbOnline');

    if (username) {
        nameArea.style.display = 'none';
        chatArea.style.display = 'flex';
    }

    function timeAgo(dateStr) {
        const diff = Date.now() - new Date(dateStr).getTime();
        const mins = Math.floor(diff / 60000);
        if (mins < 1) return 'vừa xong';
        if (mins < 60) return mins + ' phút';
        const hours = Math.floor(mins / 60);
        if (hours < 24) return hours + ' giờ';
        return Math.floor(hours / 24) + ' ngày';
    }

    function renderMsg(msg) {
        const isBot = msg.type === 'bot';
        const div = document.createElement('div');
        div.className = 'cb-msg' + (isBot ? ' cb-msg-bot' : '');
        div.innerHTML = `
            <div class="cb-msg-avatar" style="background:${msg.avatar_color}">
                ${isBot ? '<i class="fas fa-robot" style="font-size:12px"></i>' : msg.username.charAt(0).toUpperCase()}
            </div>
            <div class="cb-msg-content">
                <div class="cb-msg-header">
                    <span class="cb-msg-name ${isBot ? 'cb-bot-name' : ''}">${msg.username}</span>
                    <span class="cb-msg-time">${timeAgo(msg.created_at)}</span>
                </div>
                <div class="cb-msg-text">${msg.message.replace(/</g,'&lt;').replace(/>/g,'&gt;')}</div>
                <button class="cb-msg-like ${msg.likes > 0 ? 'cb-liked' : ''}" onclick="cbLike(${msg.id}, this)">
                    <i class="fas fa-heart"></i> ${msg.likes > 0 ? msg.likes : ''}
                </button>
            </div>`;
        return div;
    }

    async function fetchMessages() {
        try {
            const res = await fetch(API + '/messages?limit=50&site=' + SITE);
            const data = await res.json();
            if (data.success && data.data) {
                // Keep system msg
                const sys = msgContainer.querySelector('.cb-system-msg');
                msgContainer.innerHTML = '';
                if (sys) msgContainer.appendChild(sys);
                data.data.forEach(m => msgContainer.appendChild(renderMsg(m)));
                msgContainer.scrollTop = msgContainer.scrollHeight;
                if (!isOpen) {
                    unread++;
                    badge.textContent = unread > 9 ? '9+' : unread;
                    badge.style.display = 'flex';
                }
            }
        } catch(e) {}
    }

    async function fetchOnline() {
        try {
            const res = await fetch(API + '/online');
            const data = await res.json();
            if (data.success) onlineEl.textContent = data.online;
        } catch(e) {}
    }

    function openChat() {
        isOpen = true;
        floatBtn.style.display = 'none';
        window_.style.display = 'flex';
        unread = 0;
        badge.style.display = 'none';
        fetchMessages();
        fetchOnline();
        pollTimer = setInterval(() => { fetchMessages(); fetchOnline(); }, 15000);
    }

    function closeChat() {
        isOpen = false;
        window_.style.display = 'none';
        floatBtn.style.display = 'flex';
        if (pollTimer) clearInterval(pollTimer);
    }

    floatBtn.addEventListener('click', openChat);
    $('cbCloseBtn').addEventListener('click', closeChat);

    // Set name
    function setName() {
        const name = nameInput.value.trim();
        if (!name) return;
        username = name;
        localStorage.setItem('chat_username', name);
        nameArea.style.display = 'none';
        chatArea.style.display = 'flex';
        msgInput.focus();
    }
    $('cbNameBtn').addEventListener('click', setName);
    nameInput.addEventListener('keydown', e => { if (e.key === 'Enter') setName(); });

    // Send message
    async function sendMsg() {
        const text = msgInput.value.trim();
        if (!text || !username) return;
        msgInput.value = '';

        // Optimistic
        const temp = { id: Date.now(), username, avatar_color: '#3498db', message: text, type: 'user', likes: 0, created_at: new Date().toISOString() };
        msgContainer.appendChild(renderMsg(temp));
        msgContainer.scrollTop = msgContainer.scrollHeight;

        try {
            await fetch(API + '/message', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: JSON.stringify({ username, message: text, site: SITE })
            });
        } catch(e) {}
    }
    $('cbSendBtn').addEventListener('click', sendMsg);
    msgInput.addEventListener('keydown', e => { if (e.key === 'Enter') sendMsg(); });

    // Like
    window.cbLike = async function(id, btn) {
        const countEl = btn;
        const current = parseInt(countEl.textContent.replace(/\D/g,'') || '0');
        countEl.innerHTML = '<i class="fas fa-heart"></i> ' + (current + 1);
        countEl.classList.add('cb-liked');
        try { await fetch(API + '/like/' + id, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' } }); } catch(e) {}
    };
})();
</script>
