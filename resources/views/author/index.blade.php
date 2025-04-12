<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Author') }} - {{ $author->name }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4">
        <!-- Create Blog Button -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800"><i class="fa-solid fa-user"></i> Profile</h2>

            @auth
                @if (auth()->id() !== $author->id && !$author->reported)
                    <form action="{{ route('user.report', $author->id) }}" method="POST" class="ml-4">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                            onclick="return confirm('Bạn có chắc chắn muốn báo cáo tác giả này không?');">
                            Report
                        </button>
                    </form>
                {{-- @elseif ($author->reported)
                    <span class="ml-4 text-red-500">Đã báo cáo</span> --}}
                @endif
            @endauth
        </div>
        <div class="flex items-center">
            <h2 class="text-2xl font-bold text-gray-800">{{ $author->name }} - {{ $author->publicBlogsCount() }} Posts
            </h2>

        </div>
    </div>

    <div class="container mx-auto px-4">
        <!-- Create Blog Button -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800"><i class="fa-solid fa-blog"></i> Blog Posts</h2>
        </div>

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
                        <a href="{{ route('blog.show', $blog) }}">
                            <img src="{{ asset('storage/' . $blog->banner_image) }}"
                                class="card-img-bottom h-48 w-full object-cover rounded-lg cursor-pointer"
                                alt="Blog Image">
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $blogs->links() }}
        </div>
    </div>
</x-app-layout>
