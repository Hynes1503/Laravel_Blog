@extends('admin.layouts.app')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Blogs') }}
                </h2>
                <form method="GET" action="{{ route('admin.blog.search') }}" class="relative w-[600px] mr-10">
                    <div class="relative flex items-center space-x-4">
                        <input type="text" name="query" placeholder="Search..."
                            class="px-4 py-2 border rounded-lg w-full pr-16 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ request('query') }}">
                        <select name="reported_filter" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All</option>
                            <option value="blog" {{ request('reported_filter') == 'blog' ? 'selected' : '' }}>Reported Blogs</option>
                            <option value="user" {{ request('reported_filter') == 'user' ? 'selected' : '' }}>Reported Authors</option>
                            <option value="comment" {{ request('reported_filter') == 'comment' ? 'selected' : '' }}>Blogs with Reported Comments</option>
                        </select>
                        <button type="submit"
                            class="absolute inset-y-0 right-4 px-4 py-1 bg-transparent text-gray-600 hover:text-black">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container mx-auto px-4">
        <!-- Create Blog Button -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800"><i class="fa-solid fa-blog"></i>
                All Blog Posts
            </h2>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Like</th>
                    <th scope="col">Comment</th>
                    <th scope="col">Author</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blogs as $blog)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>
                            {{ Str::limit($blog->title, 10) }}
                            @if ($blog->reported)
                                <span class="text-red-500 text-xs">(Reported)</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($blog->description, 30) }}</td>
                        <td>{{ $blog->favoritesCount() }}</td>
                        <td>
                            {{ $blog->comments->count() }}
                            @php
                                $reportedComments = $blog->comments->where('reported', true)->count();
                            @endphp
                            @if ($reportedComments > 0)
                                <span class="text-red-500 text-xs">({{ $reportedComments }} Reported)</span>
                            @endif
                        </td>
                        <td>
                            {{ $blog->user->name }}
                            @if ($blog->user->reported)
                                <span class="text-red-500 text-xs">(Reported)</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex justify-center items-center space-x-2 p-2">
                                <!-- Nút View -->
                                <a href="{{ route('admin.blog.show', $blog) }}"
                                    class="px-3 py-1 rounded-md item text-white bg-green-600">
                                    <i class="fa-solid fa-eye"></i>View</a>

                                <!-- Nút Edit -->
                                <a href="{{ route('admin.blog.edit', $blog) }}"
                                    class="px-3 py-1 rounded-md item text-white bg-blue-600">
                                    <i class="fa-solid fa-pen-to-square"></i>Edit</a>

                                <!-- Nút Delete -->
                                <form action="{{ route('admin.blog.destroy', $blog) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this blog?');" class="flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 rounded-md item">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $blogs->links() }}
        </div>
    </div>
@endsection