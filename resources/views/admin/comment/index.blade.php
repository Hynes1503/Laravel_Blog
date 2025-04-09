@extends('admin.layouts.app')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Comments') }}
                </h2>
                <form method="GET" action="{{ route('admin.comment.index') }}" class="relative w-[600px] mr-10">
                    <div class="relative flex items-center space-x-4">
                        <input type="text" name="query" placeholder="Search comments..."
                            class="px-4 py-2 border rounded-lg w-full pr-16 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ request('query') }}">
                        <select name="reported_filter" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" {{ request('reported_filter') == '' ? 'selected' : '' }}>All Comments</option>
                            <option value="reported" {{ request('reported_filter') == 'reported' ? 'selected' : '' }}>Reported Comments</option>
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
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fa-solid fa-comment"></i> All Comments
            </h2>
        </div>
        <table class="table w-full">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Content</th>
                    <th scope="col">Author</th>
                    <th scope="col">Blog</th>
                    <th scope="col">Reported</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comments as $comment)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ Str::limit($comment->content, 50) }}</td>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ Str::limit($comment->blog->title, 20) }}</td>
                        <td>
                            @if ($comment->reported)
                                <span class="text-red-500 text-xs">Reported</span>
                            @else
                                <span class="text-green-500 text-xs">Unreported</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex justify-center items-center space-x-2 p-2">
                                <!-- Nút Show -->
                                <a href="{{ route('admin.blog.show', $comment->blog) }}"
                                    class="px-3 py-1 rounded-md text-white bg-green-600 hover:bg-green-700">
                                    <i class="fa-solid fa-eye"></i> Show
                                </a>
                                <!-- Nút Delete -->
                                <form action="{{ route('comment.destroy', $comment->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this comment?');" class="flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 rounded-md text-white hover:bg-red-700">
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
            {{ $comments->links() }}
        </div>
    </div>
@endsection