<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grok Chat</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(180deg, #1a1a1a 0%, #2a2a2a 100%);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #chat-box {
            width: 100%;
            max-width: 600px;
            background: #2a2a2a;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 80vh;
        }

        #messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #2a2a2a;
            color: #e0e0e0;
            display: flex;
            flex-direction: column; /* Change to column for top-to-bottom order */
        }

        #messages p {
            margin: 10px 0;
            padding: 12px 18px;
            border-radius: 15px;
            font-size: 1em;
            line-height: 1.5;
            max-width: 80%;
            word-wrap: break-word;
        }

        #messages p strong {
            display: none; /* Ẩn "You:" và "Gemini:" */
        }

        #messages p:nth-child(odd) { /* Tin nhắn của bot */
            background: #3a3a3a;
            color: #e0e0e0;
            margin-right: auto;
            text-align: left;
        }

        #messages p:nth-child(even) { /* Tin nhắn của người dùng */
            background: #4a4a4a;
            color: #ffffff;
            margin-left: auto;
            text-align: right;
        }

        .input-container {
            padding: 15px;
            background: #2a2a2a;
            border-top: 1px solid #3a3a3a;
            display: flex;
            align-items: center;
        }

        #message-input {
            flex: 1;
            padding: 12px 18px;
            border: none;
            border-radius: 25px;
            background: #3a3a3a;
            color: #e0e0e0;
            font-size: 1em;
            outline: none;
            margin-right: 10px;
        }

        #message-input::placeholder {
            color: #888888;
        }

        #message-input:focus {
            background: #4a4a4a;
        }

        button.send-btn {
            padding: 12px 20px;
            background: #4a4a4a;
            color: #ffffff;
            border: none;
            border-radius: 25px;
            font-size: 1em;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        button.send-btn:hover {
            background: #5a5a5a;
        }

        .footer-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: #2a2a2a;
            border-top: 1px solid #3a3a3a;
        }

        .footer-buttons .left-buttons button {
            background: none;
            border: none;
            color: #888888;
            font-size: 0.9em;
            cursor: pointer;
            margin-right: 15px;
        }

        .footer-buttons .left-buttons button:hover {
            color: #ffffff;
        }

        .footer-buttons .right-section {
            display: flex;
            align-items: center;
        }

        .footer-buttons .right-section span {
            color: #888888;
            font-size: 0.9em;
            margin-right: 10px;
        }

        .footer-buttons .right-section button {
            background: none;
            border: none;
            color: #888888;
            cursor: pointer;
        }

        .footer-buttons .right-section button:hover {
            color: #ffffff;
        }

        /* Thanh cuộn */
        #messages::-webkit-scrollbar {
            width: 6px;
        }

        #messages::-webkit-scrollbar-thumb {
            background: #4a4a4a;
            border-radius: 3px;
        }

        #messages::-webkit-scrollbar-track {
            background: transparent;
        }

        /* Responsive */
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            #chat-box {
                max-width: 100%;
                height: 90vh;
            }

            #message-input {
                font-size: 0.9em;
            }

            button.send-btn {
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>
    <div id="chat-box">
        <div id="messages" style="height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            @if(Auth::check())
                <p><strong>Gemini:</strong> Chào {{ Auth::user()->name }}, tôi có thể giúp gì cho bạn?</p>
            @else
                <p><strong>Gemini:</strong> Chào, bạn cần đăng nhập để sử dụng chatbot.</p>
            @endif
        </div>
        <div id="loading-indicator" style="display: none; text-align: center; padding: 10px; color: #888;">Đang chuẩn bị câu trả lời...</div>
        <div class="input-container">
            <input type="text" id="message-input" placeholder="Type a message...">
            <button class="send-btn" onclick="sendMessage()">Send</button>
        </div>
        <div class="footer-buttons">
            <div class="left-buttons">
            </div>
            <div class="right-section">
                <span>E-Learning</span>
                <button>↑</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const messagesDiv = document.getElementById('messages');
        const loadingIndicator = document.getElementById('loading-indicator');
        const messageInput = document.getElementById('message-input');

        function displayMessage(message, isUser = false) {
            const sender = isUser ? 'You' : 'Gemini';
            messagesDiv.insertAdjacentHTML('beforeend', `<p class="message ${isUser ? 'user-message' : 'ai-message'}"><strong>${sender}:</strong> ${message}</p>`);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        function loadChatHistory() {
            axios.get('/chat/history')
                .then(response => {
                    if (response.data.history) {
                        messagesDiv.innerHTML = ''; // Xóa tin nhắn chào ban đầu
                        response.data.history.forEach(message => {
                            displayMessage(message.message, message.is_user);
                        });
                        messagesDiv.scrollTop = messagesDiv.scrollHeight;
                    } else if (response.data.error) {
                        displayMessage(response.data.error);
                    }
                })
                .catch(error => {
                    console.error('Lỗi tải lịch sử chat:', error);
                    displayMessage('Không thể tải lịch sử chat.');
                });
        }

        function sendMessage() {
            const userMessage = messageInput.value.trim();
            if (!userMessage) return;

            displayMessage(userMessage, true);
            messageInput.value = '';
            loadingIndicator.style.display = 'block';

            axios.post('/chat/send', { message: userMessage })
                .then(response => {
                    const reply = response.data.reply;
                    displayMessage(reply, false);
                })
                .catch(error => {
                    displayMessage('Unable to get a response. Please try again.');
                })
                .finally(() => {
                    loadingIndicator.style.display = 'none';
                });
        }

        // Tải lịch sử chat khi trang tải xong
        document.addEventListener('DOMContentLoaded', loadChatHistory);

        // Gửi tin nhắn khi nhấn Enter
        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // Tự động focus vào input khi trang tải
        messageInput.focus();
    </script>
</body>
</html>