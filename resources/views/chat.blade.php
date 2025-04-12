<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grok Chat</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        #chat-box {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        #messages {
            flex-grow: 1;
            padding: 15px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .message {
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 18px;
            clear: both;
            word-break: break-word;
        }

        .ai-message {
            background-color: #e0f7fa;
            color: #00838f;
            align-self: flex-start;
        }

        .user-message {
            background-color: #e8eaf6;
            color: #1a237e;
            align-self: flex-end;
        }

        .input-container {
            padding: 10px;
            display: flex;
            border-top: 1px solid #eee;
        }

        #message-input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            margin-right: 10px;
            outline: none;
        }

        button.send-btn {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        button.send-btn:hover {
            background-color: #45a049;
        }

        #loading-indicator {
            text-align: center;
            padding: 10px;
            color: #777;
            font-size: 0.9em;
        }

        /* Scrollbar customization */
        #messages::-webkit-scrollbar {
            width: 8px;
        }

        #messages::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 4px;
        }

        #messages::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
        }

        #messages::-webkit-scrollbar-thumb:hover {
            background-color: #bbb;
        }

        .footer-buttons {
            display: none;
            /* Ẩn footer-buttons theo yêu cầu */
        }
    </style>
</head>

<body>
    <div id="chat-box">
        <div id="messages">
            @if (Auth::check())
                <p class="ai-message"><strong>Gemini:</strong> Chào, bạn cần đăng nhập để sử dụng chatbot.</p>
            @else
                <p class="ai-message"><strong>Gemini:</strong> Chào {{ Auth::user()->name }}, tôi có thể giúp gì cho bạn?
                </p>
            @endif
        </div>
        <div id="loading-indicator" style="display: none;">Đang chuẩn bị câu trả lời...</div>
        <div class="input-container">
            <input type="text" id="message-input" placeholder="Nhập tin nhắn...">
            <button class="send-btn" onclick="sendMessage()">Gửi</button>
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
    <script>
        const messagesDiv = document.getElementById('messages');
        const loadingIndicator = document.getElementById('loading-indicator');
        const messageInput = document.getElementById('message-input');

        function displayMessage(message, isUser = false) {
            const senderClass = isUser ? 'user-message' : 'ai-message';
            const senderName = isUser ? 'Bạn' : 'Gemini';
            messagesDiv.insertAdjacentHTML('beforeend',
                `<p class="message ${senderClass}"><strong>${senderName}:</strong> ${message}</p>`
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

            axios.post('/chat/send', {
                    message: userMessage
                })
                .then(response => {
                    const reply = response.data.reply;
                    displayMessage(reply, false);
                })
                .catch(error => {
                    displayMessage('Không thể nhận phản hồi. Vui lòng thử lại.');
                })
                .finally(() => {
                    loadingIndicator.style.display = 'none';
                });
        }

        document.addEventListener('DOMContentLoaded', loadChatHistory);

        messageInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        messageInput.focus();
    </script>
</body>

</html>
