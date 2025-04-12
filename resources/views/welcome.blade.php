<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ynes Blog - Explore amazing content and stories">

    <title>Hynes Blog</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-... (rút gọn) ..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tailwind CSS CDN for rapid styling (optional, can replace with your app.css) -->
    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex flex-col min-h-screen font-['Instrument_Sans']">
    <!-- Header -->
    <header class="w-full bg-white dark:bg-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('welcome') }}" class="flex items-center space-x-2"> <img
                        src="{{ asset('image/h_new.png') }}" alt="Ynes Logo"class="w-12 h-12"><span
                        class="text-2xl font-bold text-gray-900 dark:text-white">ynes Blog</span></a>

            </div>

            <!-- Navigation -->
            @if (Route::has('login'))
                <nav class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </header>

    <!-- Hero Section -->
    <section
        class="flex-grow flex items-center justify-center w-full py-12 lg:py-24 bg-gradient-to-r from-indigo-100 to-blue-100 dark:from-gray-800 dark:to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center">
            <!-- Text Content -->
            <div class="lg:w-1/2 text-center lg:text-left">
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    Welcome to <span class="text-indigo-600">Hynes Blog</span>
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                    Discover stories, insights, and inspiration from our vibrant community. Join us today!
                </p>
                <a href="{{ route('register') }}"
                    class="inline-block px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 transition">
                    Get Started
                </a>
            </div>
            <!-- Image -->
            <div class="lg:w-2/5 mt-8 lg:mt-0">
                <img src="{{ asset('image/hb.png') }}" alt="Blog Illustration"
                    class="w-full max-w-md mx-auto lg:max-w-full">
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Sample Blog Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ asset('image/blog1.png') }}" alt="Blog Post" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Sample Post Title</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        A brief excerpt of the blog post goes here to entice readers to click and read more...
                    </p>
                    <a href="{{ route('login') }}"
                        class="mt-4 inline-block text-indigo-600 dark:text-indigo-400 hover:underline">Read More</a>
                </div>
            </div>
            <!-- Repeat for more cards -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ asset('image/blog2.jpg') }}" alt="Blog Post" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Another Great Post</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        This is another engaging excerpt to draw readers into the full article...
                    </p>
                    <a href="{{ route('login') }}"
                        class="mt-4 inline-block text-indigo-600 dark:text-indigo-400 hover:underline">Read More</a>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <img src="{{ asset('image/blog3.jpg') }}" alt="Blog Post" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Explore More</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        Dive into this topic with a captivating summary that sparks curiosity...
                    </p>
                    <a href="{{ route('login') }}"
                        class="mt-4 inline-block text-indigo-600 dark:text-indigo-400 hover:underline">Read More</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 dark:bg-gray-900 text-gray-300 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- About -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">About Hynes Blog</h4>
                    <p class="text-sm">
                        Hynes Blog is your go-to place for inspiring stories, tips, and community insights.
                    </p>
                </div>
                <!-- Links -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Home</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                <!-- Social -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/Hynes153/" class="text-gray-300 hover:text-white transition"
                            target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/hynes_153/?hl=en"
                            class="text-gray-300 hover:text-white transition" target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="https://github.com/Hynes1503" class="text-gray-300 hover:text-white transition"
                            target="_blank" rel="noopener noreferrer">
                            <i class="fa-brands fa-github"></i>
                        </a>
                    </div>

                </div>
            </div>
            <div class="mt-8 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} Hynes Blog. All rights reserved.
            </div>
        </div>
    </footer>
</body>

</html>
