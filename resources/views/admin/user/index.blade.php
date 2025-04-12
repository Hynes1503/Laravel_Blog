@extends('admin.layouts.app')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Users') }}
                </h2>
                <form method="GET" action="{{ route('admin.user.search') }}" class="relative w-[600px] mr-10">
                    <div class="relative flex items-center space-x-4">
                        <input type="text" name="query" placeholder="Search..."
                            class="px-4 py-2 border rounded-lg w-full pr-16 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ request('query') }}">
                        <select name="reported_filter" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="" {{ request('reported_filter') == '' ? 'selected' : '' }}>All Users</option>
                            <option value="reported" {{ request('reported_filter') == 'reported' ? 'selected' : '' }}>Reported Users</option>
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
                <i class="fa-solid fa-user"></i> All Users
            </h2>
            <a href="{{ route('admin.user.create') }}"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-blue-700 transition bg-black">
                <i class="fa-solid fa-plus"></i> Create New User
            </a>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Blogs</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>
                            {{ $user->name }}
                            @if ($user->reported)
                                <br><span class="text-red-500 text-xs">Reported</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->BlogsCount() }}</td>
                        <td>
                            <div class="flex justify-center items-center space-x-2 p-2">

                                <a href="{{ route('admin.user.show', $user->id) }}"
                                    class="px-3 py-1 rounded-md item text-white bg-green-600">
                                    <i class="fa-solid fa-eye"></i>View
                                </a>

                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                    class="px-3 py-1 rounded-md item text-white bg-blue-600">
                                    <i class="fa-solid fa-pen-to-square"></i>Edit
                                </a>
 
                                <form action="{{ route('admin.user.destroy', $user) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this user?');" class="flex">
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
            {{ $users->links() }}
        </div>
    </div>
@endsection