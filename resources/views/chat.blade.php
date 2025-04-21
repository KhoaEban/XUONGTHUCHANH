<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chatbot</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f0f2f5;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        #chat-wrapper {
            width: 100%;
            max-width: 450px;
            height: 90vh;
            background: #fff;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .chat-header {
            background-color: #008040;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }

        #messages {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: #f0f2f5;
        }

        .message {
            display: flex;
            align-items: flex-end;
        }

        .message .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            margin-right: 10px;
            flex-shrink: 0;
            background-size: cover;
            background-position: center;
            transform: scaleX(-1);
        }

        .message-content {
            padding: 10px 14px;
            border-radius: 16px;
            max-width: 70%;
            word-break: break-word;
            font-size: 14px;
            line-height: 1.4;
        }

        .ai-message {
            flex-direction: row;
        }

        .ai-message .message-content {
            background-color: #ecfdf5;
            color: #1f2a44;
        }

        .user-message {
            flex-direction: row-reverse;
        }

        .user-message .avatar {
            margin-left: 10px;
            margin-right: 0;
        }

        .user-message .message-content {
            background-color: #008040;
            color: white;
        }

        .chat-footer {
            background: #fff;
            padding: 10px 15px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
        }

        #message-input {
            flex-grow: 1;
            padding: 10px 15px;
            border-radius: 20px;
            border: none;
            font-size: 14px;
            outline: none;
            background-color: #f9fafb;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }

        .send-btn {
            background: none;
            border: none;
            margin-left: 10px;
            cursor: pointer;
        }

        .send-btn svg {
            width: 24px;
            height: 24px;
            fill: #008040;
        }

        #loading-indicator {
            text-align: center;
            color: #6b7280;
            font-size: 13px;
            margin: 5px 0;
        }

        @media (max-width: 480px) {
            #chat-wrapper {
                height: 100vh;
                max-width: 100%;
                border-radius: 0;
            }
        }
    </style>
</head>

<body>
    <div id="chat-wrapper">
        <div class="chat-header">
            <div class="d-flex align-items-center gap-2" style="width: 50px; height: 50px; background-color: #ffffff; border-radius: 50%;">
                <img src="{{ asset('image/logochat.png') }}" width="50" height="50" class="rounded-circle tranform-scale-2" style="object-fit: cover; border-radius: 50px;" alt="Logo">
                Chatbot
            </div>
        </div>
        <div id="messages">
            @if (Auth::check())
                <div class="message ai-message">
                    <div class="avatar" style="background-image: url('https://i.ibb.co/GP7CgWZ/bot-avatar.png');"></div>
                    <div class="message-content"><strong>Gemini:</strong> Chào {{ Auth::user()->name }}, tôi có thể giúp gì cho bạn?</div>
                </div>
            @else
                <div class="message ai-message">
                    <div class="avatar" style="background-image: url('https://i.ibb.co/GP7CgWZ/bot-avatar.png');"></div>
                    <div class="message-content"><strong>Gemini:</strong> Chào, bạn cần đăng nhập để sử dụng chatbot.</div>
                </div>
            @endif
        </div>
        <div id="loading-indicator" style="display: none;">Đang chuẩn bị câu trả lời...</div>
        <div class="chat-footer">
            <input type="text" id="message-input" placeholder="Nhập tin nhắn...">
            <button class="send-btn" onclick="sendMessage()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                </svg>
            </button>
        </div>
    </div>

    <script>
        const messagesDiv = document.getElementById('messages');
        const loadingIndicator = document.getElementById('loading-indicator');
        const messageInput = document.getElementById('message-input');

        // Lấy avatar của user nếu đã đăng nhập, nếu không thì dùng ảnh mặc định
        const userAvatar = `{{ Auth::check() && Auth::user()->avatar ? asset(Auth::user()->avatar) : 'https://i.ibb.co/4Y74sM7/default-user.png' }}`;
        const botAvatar = '{{ asset('image/logochat.png') }}';

        function displayMessage(message, isUser = false) {
            const senderClass = isUser ? 'user-message' : 'ai-message';
            const senderName = isUser ? 'Bạn' : 'Gemini';
            const avatar = isUser ? userAvatar : botAvatar;

            messagesDiv.insertAdjacentHTML('beforeend',
                `<div class="message ${senderClass}">
                    <div class="avatar" style="background-image: url('${avatar}')"></div>
                    <div class="message-content"><strong>${senderName}:</strong> ${message}</div>
                </div>`
            );
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        function loadChatHistory() {
            axios.get('/chat/history')
                .then(response => {
                    if (response.data.history) {
                        messagesDiv.innerHTML = '';
                        response.data.history.forEach(message => {
                            displayMessage(message.message, message.is_user);
                        });
                    } else if (response.data.error) {
                        displayMessage(response.data.error);
                    }
                })
                .catch(() => {
                    displayMessage('Không thể tải lịch sử chat.');
                });
        }

        function sendMessage() {
            const userMessage = messageInput.value.trim();
            if (!userMessage) return;

            displayMessage(userMessage, true);
            messageInput.value = '';
            loadingIndicator.style.display = 'block';

            axios.post('/chat/send', {
                    message: userMessage
                })
                .then(response => {
                    displayMessage(response.data.reply, false);
                })
                .catch(() => {
                    displayMessage('Không thể nhận phản hồi. Vui lòng thử lại.');
                })
                .finally(() => {
                    loadingIndicator.style.display = 'none';
                });
        }

        document.addEventListener('DOMContentLoaded', loadChatHistory);
        messageInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') sendMessage();
        });

        messageInput.focus();
    </script>
</body>

</html>