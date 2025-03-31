<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('tilte', 'HynesBlog')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('image/favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN cho tính năng tương tác -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
    <style>
        /* Tùy chỉnh thêm nếu cần */
        .nav-link {
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: #4b5563;
            /* Màu xám đậm khi hover */
        }

        /* Hiệu ứng chuyển động cho sidebar */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <!-- Navbar dọc ở rìa trái -->
    <div x-data="{ sidebarOpen: true }">
        <nav class="bg-black border-r border-gray-100 fixed top-0 left-0 h-screen w-64 text-white sidebar"
            :class="{ 'sidebar-hidden': !sidebarOpen }">
            <!-- Primary Navigation Menu -->
            <div class="flex flex-col h-full px-4 py-6">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mb-6">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('image/favicon-dark.png') }}" alt="Logo" class="w-12 h-8">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="space-y-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link block px-3 py-2 rounded-md text-white hover:text-gray-200">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.user.index') }}"
                        class="nav-link block px-3 py-2 rounded-md text-white hover:text-gray-200">
                        Users
                    </a>
                    <a href="{{ route('admin.blog.index') }}"
                        class="nav-link block px-3 py-2 rounded-md text-white hover:text-gray-200">
                        Blogs
                    </a>
                    <a href="{{ route('categories.index') }}"
                        class="nav-link block px-3 py-2 rounded-md text-white hover:text-gray-200">
                        Categories
                    </a>
                </div>

                <!-- Settings Dropdown -->
                <div class="mt-auto">
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = !dropdownOpen"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 w-full justify-between">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            </div>
                        </button>
                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                            class="absolute bottom-full mb-2 w-48 bg-white rounded-md shadow-lg">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Setting
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Nút đóng sidebar (chỉ hiển thị trong sidebar) -->
                <div class="mt-4">
                    <button @click="sidebarOpen = false"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Nút mở sidebar (hiển thị khi sidebar bị ẩn) -->
        <button @click="sidebarOpen = true" class="fixed top-4 left-4 p-2 bg-black text-white rounded-md z-50"
            :class="{ 'hidden': sidebarOpen }">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Nội dung chính -->
        <div class="transition-all duration-300" :class="{ 'ml-64': sidebarOpen, 'ml-0': !sidebarOpen }">
            @section('success')
                <div class="success-message">{{ session('success') }}</div>
            @endsection
            <div class="p-6">
                <header class="mb-6">
                    @yield('header')
                </header>
                <main>
                    <section class="bg-white p-6 rounded-lg shadow-md">
                        @yield('content')
                    </section>
                </main>
            </div>
        </div>
    </div>
</body>

</html>
