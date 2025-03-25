<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Discover') }}
            </h2>
            <div class="hidden sm:flex sm:items-center mx-auto">
                <x-search-bar />
            </div>
        </div>
    </x-slot>


    <div class="container mx-auto px-4 py-8">
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
                        <img src="{{ asset('storage/' . $blog->banner_image) }}"
                            class="card-img-bottom h-48 w-full object-cover" alt="Blog Image">
                    @endif
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $blogs->links() }}
        </div>
    </div>
</x-app-layout>
