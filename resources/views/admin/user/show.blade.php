@extends('admin.layouts.app')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Users') }}
                </h2>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container mx-auto px-4">
        <!-- Create Blog Button -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold {{ $author->reported ? 'text-red-500' : 'text-gray-800' }}">
                <i class="fa-solid fa-user"></i> Profile
            </h2>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $author->name }} - {{ $author->BlogsCount() }} Posts
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
                            <a href="{{ route('admin.blog.show', $blog) }}" class="hover:underline cursor-pointer">
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
                        <a href="{{ route('admin.blog.show', $blog) }}">
                            <img src="{{ asset('storage/' . $blog->banner_image) }}"
                                class="card-img-bottom h-48 w-full object-cover rounded-lg cursor-pointer" alt="Blog Image">
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $blogs->links() }}
        </div>
    </div>
@endsection