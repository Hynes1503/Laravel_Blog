@extends('admin.layouts.app')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <div class="hidden sm:flex sm:items-center mx-auto">
                    @yield('search-bar')
                </div>
            </div>
        </div>
    </header>
    {{-- <div class="flex items-center justify-between w-full">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Discover') }}
        </h2>
        <div class="hidden sm:flex sm:items-center mx-auto">
            <x-search-bar />
        </div>
    </div> --}}
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('admin.user.index') }}" class="block">
                <div class="card shadow-lg rounded-lg overflow-hidden"
                    style="background-image: url('{{ asset('image/User_Icon.png') }}'); background-size: cover; background-position: center; width: 300px; height: 300px;">
                    <div class="card-body bg-white bg-opacity-75 p-4 rounded h-full">
                        <h5 class="card-title text-xl font-semibold text-gray-800">
                            <i class="fa-solid fa-circle-user"></i> Users
                        </h5>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.blog.index') }}" class="block">
                <div class="card shadow-lg rounded-lg overflow-hidden"
                    style="background-image: url('{{ asset('image/Blog_Icon.png') }}'); background-size: cover; background-position: center; width: 300px; height: 300px;">
                    <div class="card-body bg-white bg-opacity-75 p-4 rounded h-full">
                        <h5 class="card-title text-xl font-semibold text-gray-800">
                            <i class="fa-solid fa-circle-user"></i> Blogs
                        </h5>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('categories.index') }}" class="block">
                <div class="card shadow-lg rounded-lg overflow-hidden"
                    style="background-image: url('{{ asset('image/category_icon.png') }}'); background-size: cover; background-position: center; width: 300px; height: 300px;">
                    <div class="card-body bg-white bg-opacity-75 p-4 rounded h-full">
                        <h5 class="card-title text-xl font-semibold text-gray-800">
                            <i class="fa-solid fa-circle-user"></i> Categories
                        </h5>
                    </div>
                </div>
            </a>
            
        </div>
    </div>
@endsection
