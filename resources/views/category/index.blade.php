<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Categories') }}: {{ $category->name }}
            </h2>
            <div class="hidden sm:flex sm:items-center mx-auto">
                <x-search-bar />
            </div>
        </div>
    </x-slot>


    <div class="container mx-auto px-4 py-8">
        @if ($blogs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($blogs as $blog)
                    <div class="card shadow-lg rounded-lg overflow-hidden">
                        <div class="card-body">
                            <h5 class="card-title text-xl font-semibold text-gray-800">
                                <a href="{{ route('blog.show', $blog) }}" class="hover:underline cursor-pointer">
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
                            <a href="{{ route('blog.show', $blog) }}"> <img
                                    src="{{ asset('storage/' . $blog->banner_image) }}"
                                    class="card-img-bottom h-48 w-full object-cover" alt="Blog Image"></a>
                        @endif
                        <div class="flex justify-center items-center space-x-2 bg-black p-2">
                            <form method="POST" action="{{ route('blog.favorite', $blog->id) }}">
                                @csrf
                                <div class="flex items-center space-x-4">
                                    <button type="submit" class="px-3 py-1 text-white rounded-md item bg-transparent">
                                        @if ($blog->isFavoritedBy(auth()->user()))
                                            <i class="fa-solid fa-heart"></i> {{ $blog->favoritesCount() }}
                                        @else
                                            <i class="fa-regular fa-heart"></i> {{ $blog->favoritesCount() }}
                                        @endif
                                    </button>
                                </div>
                            </form>
                            <a href="{{ route('blog.show', $blog) }}" class="px-3 py-1 text-white rounded-md item">
                                <i class="fa-regular fa-comment"></i> {{ $blog->comments->count() }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $blogs->links() }}
            </div>
        @else
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                There are no blogs in this category.
            </h2>
        @endif
    </div>
</x-app-layout>
