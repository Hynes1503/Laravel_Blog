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
    <div class="container mx-auto px-4 py-8">
        <!-- Page Heading -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Create New Users</h2>
            <a href="{{ url()->previous() }}"
                class="px-4 py-2 bg-gray-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-gray-700 transition">
                ← Back
            </a>
        </div>

        <!-- Form Container -->
        <div class="bg-white shadow-lg rounded-lg p-6 max-w-2xl mx-auto">
            <form action="{{ route('admin.user.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- name Field -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" value=""
                        class="mt-1 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                        placeholder="Enter name">
                </div>
                @error('name')
                    <div class="error text-red-500">{{ $message }}</div>
                @enderror


                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="text" id="email" name="email" value=""
                        class="mt-1 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                        placeholder="Enter email">
                </div>
                @error('email')
                    <div class="error text-red-500">{{ $message }}</div>
                @enderror

                <!-- Description Field -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password"
                        class="mt-1 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                        placeholder="Enter password">
                </div>
                @error('password')
                    <div class="error text-red-500">{{ $message }}</div>
                @enderror

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-black text-white py-3 rounded-lg font-semibold shadow-md hover:bg-blue-700 transition">
                        <i class="fa-solid fa-plus"></i> Create User
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
