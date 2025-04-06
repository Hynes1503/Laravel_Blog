<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('tilte', 'HynesBlog')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v20.0">
    </script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            @section('success')
                <div class="success-message">{{ session('success') }}</div>
            @endsection
            {{ $slot }}

            <!-- Chatbot Toggle Button -->
            <div class="fixed bottom-4 right-4">
                <button id="toggle-chat"
                    class="w-12 h-12 bg-black rounded-full flex items-center justify-center shadow-lg hover:bg-gray-700 transition bg-center bg-no-repeat bg-cover"
                    style="background-image: url('{{ asset('image/gemini_icon.png') }}');">
                </button>
            </div>

            <div id="chat-widget" class="fixed bottom-16 right-4 w-80 bg-white shadow-lg rounded-lg overflow-hidden"
                style="display: none;">
                <!-- Chatbot Header -->
                <div class="bg-black text-white p-2 flex justify-between items-center">
                    <span>Chat with Gemini</span>
                    <button id="close-chat" class="bg-black text-white p-2 rounded hover:bg-gray-700 transition">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Chatbox -->
                <div id="chatbox" class="p-4 h-64 overflow-y-auto">
                    <div class="message bot text-gray-700 bg-gray-200 p-2 rounded-lg mb-2">Hello! How can I help you?
                    </div>
                </div>

                <!-- Chat Input -->
                <div class="p-2 border-t flex items-center">
                    <input type="text" id="chat-input" class="flex-1 p-2 border rounded-lg mr-2"
                        placeholder="Enter message...">
                    <button id="send-message" class="bg-black text-white p-2 rounded hover:bg-gray-700 transition">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </div>
            </div>

            <!-- CSS để thêm font Dubai Regular -->
            <style>
                #chatbox .message {
                    font-family: "Dubai Regular", sans-serif;
                }
            </style>

            <!-- JavaScript -->
            <script>
                const chatWidget = document.getElementById('chat-widget');
                const chatbox = document.getElementById('chatbox');
                const chatInput = document.getElementById('chat-input');
                const toggleChat = document.getElementById('toggle-chat');
                const closeChat = document.getElementById('close-chat');
                const sendMessage = document.getElementById('send-message');
                let isChatOpen = false;

                // Toggle chatbot visibility
                toggleChat.addEventListener('click', () => {
                    isChatOpen = !isChatOpen;
                    chatWidget.style.display = isChatOpen ? 'block' : 'none';
                });

                // Close chatbot
                closeChat.addEventListener('click', () => {
                    isChatOpen = false;
                    chatWidget.style.display = 'none';
                });

                // Handle message sending
                sendMessage.addEventListener('click', async (e) => {
                    e.preventDefault();
                    const message = chatInput.value.trim();
                    if (!message) return;

                    // Hiển thị tin nhắn người dùng
                    chatbox.innerHTML +=
                        `<div class="message user text-blue-600 text-right bg-gray-200 p-2 rounded-lg mb-2">${message}</div>`;
                    chatInput.value = '';
                    chatbox.scrollTop = chatbox.scrollHeight;

                    try {
                        const response = await fetch('{{ route('gemini.chat') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                message
                            })
                        });

                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }

                        const data = await response.json();
                        chatbox.innerHTML +=
                            `<div class="message bot text-gray-700 bg-gray-200 p-2 rounded-lg mb-2">${data.reply}</div>`;
                        chatbox.scrollTop = chatbox.scrollHeight;
                    } catch (error) {
                        console.error('Fetch Error:', error);
                        chatbox.innerHTML +=
                            `<div class="message bot text-red-500 bg-gray-200 p-2 rounded-lg mb-2">Có lỗi xảy ra: ${error.message}</div>`;
                    }
                });
            </script>
        </main>
    </div>
    @include('layouts.footer')
</body>

</html>
