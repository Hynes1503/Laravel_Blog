<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gemini Chatbot</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        #chatbox { border: 1px solid #ccc; padding: 10px; height: 400px; overflow-y: scroll; }
        .message { margin: 10px 0; }
        .user { text-align: right; color: blue; }
        .bot { text-align: left; color: green; }
        #input-form { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Chat với Gemini</h1>
    <div id="chatbox"></div>
    <form id="input-form">
        <input type="text" id="message" placeholder="Nhập tin nhắn..." style="width: 70%;">
        <button type="submit">Gửi</button>
    </form>

    <script>
        const chatbox = document.getElementById('chatbox');
        const form = document.getElementById('input-form');
        const input = document.getElementById('message');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const message = input.value.trim();
            if (!message) return;

            chatbox.innerHTML += `<div class="message user">${message}</div>`;
            input.value = '';
            chatbox.scrollTop = chatbox.scrollHeight;

            try {
                const response = await fetch('{{ route("gemini.chat") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message })
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();
                console.log('API Response:', data); // Debug

                chatbox.innerHTML += `<div class="message bot">${data.reply}</div>`;
                chatbox.scrollTop = chatbox.scrollHeight;
            } catch (error) {
                console.error('Fetch Error:', error);
                chatbox.innerHTML += `<div class="message bot">Có lỗi xảy ra: ${error.message}</div>`;
            }
        });
    </script>
</body>
</html>