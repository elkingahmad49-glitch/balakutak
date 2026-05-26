<button class="chatbot-toggle" id="chatbotToggle" title="{{ __('menu.chatbot_title') }}">
    <i class="fas fa-comment-dots"></i>
</button>

<div class="chatbot-window" id="chatbot">
    <div class="chatbot-header">
        <span><i class="fas fa-comment-dots me-2"></i>{{ __('menu.chatbot_assistant') }}</span>
        <button id="chatbotCloseBtn" class="btn p-0 text-white btn-sm">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="chatbot-messages" id="chatMessages">
        <div class="chat-bubble bot">
            {{ __('menu.chatbot_welcome') }}<br>
            • {{ __('menu.chatbot_faq_reg') }}<br>
            • {{ __('menu.chatbot_faq_cur') }}<br>
            • {{ __('menu.chatbot_faq_lec') }}<br>
            • {{ __('menu.chatbot_faq_age') }}<br>
            • {{ __('menu.chatbot_faq_con') }}
        </div>
    </div>

    <div class="chatbot-input">
        <input type="text" id="chatInput" placeholder="{{ __('menu.chatbot_placeholder') }}" onkeydown="if(event.key==='Enter') sendChat()">
        <button onclick="sendChat()"><i class="fas fa-paper-plane fa-sm"></i></button>
    </div>
</div>

<script>
const chatFAQ = {
    'pendaftaran': `{!! __('menu.chatbot_res_reg', ['url' => route('contact.index'), 'phone' => \App\Models\Setting::get('contact_phone', '-')]) !!}`,
    'kurikulum': `{!! __('menu.chatbot_res_cur', ['url' => route('academic')]) !!}`,
    'dosen': `{!! __('menu.chatbot_res_lec', ['url' => route('lecturers.index')]) !!}`,
    'kontak': `{!! __('menu.chatbot_res_con', ['email' => \App\Models\Setting::get('contact_email', '-'), 'phone' => \App\Models\Setting::get('contact_phone', '-')]) !!}`,
    'alamat': `{!! __('menu.chatbot_res_adr', ['address' => \App\Models\Setting::get('contact_address', '-')]) !!}`,
    'agenda': `{!! __('menu.chatbot_res_age', ['url' => route('events.index')]) !!}`,
    'berita': `{!! __('menu.chatbot_res_new', ['url' => route('posts.index')]) !!}`,
    'galeri': `{!! __('menu.chatbot_res_gal', ['url' => route('gallery.index')]) !!}`,
    'default': `{!! __('menu.chatbot_res_def', ['url' => route('contact.index')]) !!}`
};

function sendChat() {
    const input = document.getElementById('chatInput');
    const messages = document.getElementById('chatMessages');
    const text = input.value.trim();
    if (!text) return;

    // User bubble
    messages.innerHTML += `<div class="chat-bubble user">${text}</div>`;
    input.value = '';

    // Find answer
    setTimeout(() => {
        const lower = text.toLowerCase();
        let answer = chatFAQ.default;
        for (const [key, response] of Object.entries(chatFAQ)) {
            if (lower.includes(key)) { answer = response; break; }
        }
        messages.innerHTML += `<div class="chat-bubble bot">${answer}</div>`;
        messages.scrollTop = messages.scrollHeight;
    }, 600);

    messages.scrollTop = messages.scrollHeight;
}

document.addEventListener('DOMContentLoaded', function() {
    const chatbotToggle = document.getElementById('chatbotToggle');
    const chatbotWindow = document.getElementById('chatbot');
    const chatbotCloseBtn = document.getElementById('chatbotCloseBtn');
    
    if (chatbotToggle && chatbotWindow) {
        // Toggle window on click
        chatbotToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            chatbotWindow.classList.toggle('open');
        });
        
        // Close window on close button click
        if (chatbotCloseBtn) {
            chatbotCloseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                chatbotWindow.classList.remove('open');
            });
        }
        
        // Close when clicking outside of window and toggle button
        document.addEventListener('click', function(e) {
            if (!chatbotWindow.contains(e.target) && !chatbotToggle.contains(e.target)) {
                chatbotWindow.classList.remove('open');
            }
        });
        
        // Prevent closing window when clicking inside it
        chatbotWindow.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
</script>
