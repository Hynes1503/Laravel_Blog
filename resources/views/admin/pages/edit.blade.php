@extends('admin.layouts.app')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Pages') }}
                </h2>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Page Heading -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800"><i class="fa-solid fa-pen-to-square"></i> Update Page</h2>
            <a href="{{ route('admin.pages.index') }}"
                class="px-4 py-2 bg-gray-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-gray-700 transition">
                <i class="fa-solid fa-arrow-left"></i>Back
            </a>
        </div>

        <!-- Form Container -->
        <div class="bg-white shadow-lg rounded-lg p-6 max-w-2xl mx-auto">
            <form action="{{ route('admin.pages.update', $page) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                    <input type="text" id="title" name="title" value="{{ $page->title }}"
                        class="mt-1 p-3 w-full border border-gray-300 rounded-lg shadow-sm bg-gray-100"
                        placeholder="Enter title" readonly>
                </div>


                <div class="mb-4">
                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug:</label>
                    <input type="text" id="slug" name="slug" value="{{ $page->slug }}"
                        class="mt-1 p-3 w-full border border-gray-300 rounded-lg shadow-sm bg-gray-100"
                        placeholder="Enter slug" readonly>
                </div>

                <!-- Content Field -->
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700">Content:</label>
                    <textarea id="content" name="content" rows="4"
                        class="mt-1 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                        placeholder="Enter content">{{ $page->content }}</textarea>
                    @error('content')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Field -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
                    <select id="status" name="status"
                        class="mt-1 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">
                        <option value="published" {{ $page->status === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ $page->status === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full border border-black text-black py-3 rounded-lg font-semibold shadow-md hover:bg-gray-300 hover:text-white transition bg-white">
                        <i class="fa-solid fa-check"></i> Update Page
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
