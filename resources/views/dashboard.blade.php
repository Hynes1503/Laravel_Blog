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
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-3">
                        {{ __('Featured Blogs') }}
                    </h2>
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
                                        <p>{{ Str::limit($topFavoritedBlog->description, 100) }}</p>
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
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-3">
                        {{ __('Recently Updated') }}
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($recentBlogs as $blog)
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
                                        {{ Str::limit($blog->description, 100) }}
                                    </p>

                                </div>
                                @if ($blog->banner_image)
                                    <img src="{{ asset('storage/' . $blog->banner_image) }}"
                                        class="card-img-bottom h-48 w-full object-cover" alt="Blog Image">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
