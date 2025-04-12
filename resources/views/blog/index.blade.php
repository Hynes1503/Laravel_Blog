<x-app-layout>
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800"><i class="fa-solid fa-user"></i> Profile</h2>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                {{ Auth::user()->name }} - {{ Auth::user()->blogs()->count() + Auth::user()->sharedBlogs()->count() }} Posts
            </h2>
        </div>
    </div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800"><i class="fa-solid fa-blog"></i> Blog Posts</h2>
            <a href="{{ route('blog.create') }}"
               class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-blue-700 transition bg-black">
                <i class="fa-solid fa-plus"></i> Create New Blog
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($allBlogs as $blog)
                <div class="card shadow-lg rounded-lg overflow-hidden">
                    <div class="card-body">
                        <h5 class="card-title text-xl font-semibold text-gray-800">
                            <a href="{{ route('blog.show', $blog->id) }}" class="hover:underline cursor-pointer">
                                {{ $blog->title }}
                            </a>
                        </h5>
                        <p class="card-text text-gray-500">
                            <small>
                                @if ($blog->user_id === Auth::id() && !$blog->shared_by)
                                    Created {{ \Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}
                                @else
                                    Shared {{ \Carbon\Carbon::parse($blog->shared_at)->diffForHumans() }} (by {{ \App\Models\User::find($blog->user_id)->name }})
                                @endif
                            </small>
                        </p>
                        <p class="card-text text-gray-700">
                            {{ Str::limit($blog->description, 100) }}
                        </p>
                    </div>
                    @if ($blog->banner_image)
                        <a href="{{ route('blog.show', $blog->id) }}">
                            <img src="{{ asset('storage/' . $blog->banner_image) }}"
                                 class="card-img-bottom h-48 w-full object-cover rounded-lg cursor-pointer"
                                 alt="Blog Image">
                        </a>
                    @endif

                    <div class="flex justify-center items-center space-x-2 bg-black p-2">
                        @if ($blog->user_id === Auth::id() && !$blog->shared_by)
                            <a href="{{ route('blog.edit', $blog->id) }}" class="px-3 py-1 text-white rounded-md item">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <form action="{{ route('blog.destroy', $blog->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this blog?');" class="flex">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-transparent text-white rounded-md item">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        {{-- <div class="mt-4">
            {{ $allBlogs->links() }}
        </div> --}}
    </div>
</x-app-layout>