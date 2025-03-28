<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="font-semibold text-3xl text-gray-800 leading-tight mb-3">
                        {{ __('Featured Blogs') }}
                    </h1>
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel"
                        data-bs-interval="2000">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            @foreach ($topFavoritedBlogs as $index => $topFavoritedBlog)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <div class="overlay"></div> <!-- Lớp phủ tối -->
                                    <a href="{{ route('blog.show', $topFavoritedBlog) }}">
                                        <img src="{{ asset('storage/' . $topFavoritedBlog->banner_image) }}"
                                            class="d-block w-100" alt="{{ $topFavoritedBlog->title }}">
                                    </a>
                                    <div class="carousel-caption d-none d-md-block">
                                        <h2>{{ $topFavoritedBlog->title }}</h2>
                                        <p>{{ Str::limit($topFavoritedBlog->description, 50) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="font-semibold text-3xl text-gray-800 leading-tight mb-3">
                        {{ __('Recently Updated') }}
                    </h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($recentBlogs as $recentBlog)
                            <div class="card shadow-lg rounded-lg overflow-hidden">
                                <div class="card-body">
                                    <h5 class="card-title text-xl font-semibold text-gray-800">
                                        <a href="{{ route('blog.show', $recentBlog) }}"
                                            class="hover:underline cursor-pointer">
                                            {{ $recentBlog->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-gray-500">
                                        <small>Last updated {{ $recentBlog->updated_at->diffForHumans() }}</small>
                                    </p>
                                    <p class="card-text text-gray-700">
                                        {{ Str::limit($recentBlog->description, 100) }}
                                    </p>
                                </div>
                                @if ($recentBlog->banner_image)
                                    <a href="{{ route('blog.show', $recentBlog) }}"> <img
                                            src="{{ asset('storage/' . $recentBlog->banner_image) }}"
                                            class="card-img-bottom h-48 w-full object-cover" alt="Blog Image"></a>
                                @endif
                                <div class="flex justify-center items-center space-x-2 bg-black p-2">
                                    <!-- Nút tim // đang lỗi-->
                                    <form method="POST" action="{{ route('blog.favorite', $recentBlog->id) }}">
                                        @csrf
                                        <div class="flex items-center space-x-4">
                                            <button type="submit"
                                                class="px-3 py-1 text-white rounded-md item bg-transparent">
                                                @if ($recentBlog->isFavoritedBy(auth()->user()))
                                                    <i class="fa-solid fa-heart"></i>
                                                    {{ $recentBlog->favoritesCount() }}
                                                @else
                                                    <i class="fa-regular fa-heart"></i>
                                                    {{ $recentBlog->favoritesCount() }}
                                                @endif
                                            </button>
                                        </div>
                                    </form>
                                    <!-- Nút cmt -->
                                    <a href="{{ route('blog.show', $recentBlog) }}"
                                        class="px-3 py-1 text-white rounded-md item">
                                        <i class="fa-regular fa-comment"></i> {{ $recentBlog->comments->count() }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <h1 class="font-semibold text-3xl text-gray-800 leading-tight mb-3 text-right">
                            {{ __('Discover') }}
                        </h1>
                        <a href="{{ route('discover.index') }}" class="text-left text-blue-500 hover:text-blue-700">
                            View All <i class="fa-solid fa-right-long"></i>
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($blogs as $blog)
                            <div class="card shadow-lg rounded-lg overflow-hidden">
                                <div class="card-body">
                                    <h5 class="card-title text-xl font-semibold text-gray-800">
                                        <a href="{{ route('blog.show', $blog) }}"
                                            class="hover:underline cursor-pointer">
                                            {{ $blog->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-gray-500">
                                        <small>Last updated {{ $blog->updated_at->diffForHumans() }}</small>
                                    </p>
                                    <p class="card-text text-gray-700">
                                        {{ Str::limit($blog->description, 50) }}
                                    </p>
                                </div>
                                @if ($blog->banner_image)
                                    <a href="{{ route('blog.show', $blog) }}"> <img
                                            src="{{ asset('storage/' . $blog->banner_image) }}"
                                            class="card-img-bottom h-48 w-full object-cover" alt="Blog Image"></a>
                                @endif
                                <div class="flex justify-center items-center space-x-2 bg-black p-2">
                                    <!-- Nút tim // đang lỗi-->
                                    <form method="POST" action="{{ route('blog.favorite', $blog->id) }}">
                                        @csrf
                                        <div class="flex items-center space-x-4">
                                            <button type="submit"
                                                class="px-3 py-1 text-white rounded-md item bg-transparent">
                                                @if ($blog->isFavoritedBy(auth()->user()))
                                                    <i class="fa-solid fa-heart"></i> {{ $blog->favoritesCount() }}
                                                @else
                                                    <i class="fa-regular fa-heart"></i> {{ $blog->favoritesCount() }}
                                                @endif
                                            </button>
                                        </div>
                                    </form>
                                    <!-- Nút cmt -->
                                    <a href="{{ route('blog.show', $blog) }}"
                                        class="px-3 py-1 text-white rounded-md item">
                                        <i class="fa-regular fa-comment"></i> {{ $blog->comments->count() }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
