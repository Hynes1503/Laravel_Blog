@extends('admin.layouts.app')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Categories') }}: {{ $category->name }}
                </h2>
                <div class="hidden sm:flex sm:items-center mx-auto">
                    @yield('search-bar')
                </div>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        @if ($blogs->count() > 0)
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tilte</th>
                        <th scope="col">Description</th>
                        <th scope="col">Author</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $blog)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ Str::limit($blog->title, 10) }}</td>
                            <td>{{ Str::limit($blog->description, 30) }}</td>
                            <td>{{ $blog->user->name }}</td>
                            <td>
                                <div class="flex justify-center items-center space-x-2 p-2">
                                    <!-- Nút View -->
                                    <a href="{{ route('admin.blog.show', $blog) }}"
                                        class="px-3 py-1 rounded-md item text-white bg-green-600">
                                        <i class="fa-solid fa-eye"></i>View</a>

                                    <!-- Nút Edit -->
                                    <a href="{{ route('admin.blog.edit', $blog) }}"
                                        class="px-3 py-1 rounded-md item text-white bg-blue-600">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Edit</a>

                                    <!-- Nút Delete -->
                                    <form action="{{ route('admin.blog.destroy', $blog) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this blog?');"
                                        class="flex">
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
        @else
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    There are no blogs in this category.
                </h2>
                <a href="{{ url()->previous() }}"
                    class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-blue-700 transition bg-black">
                    ← Back
                </a>
            </div>
        @endif
    </div>
@endsection
