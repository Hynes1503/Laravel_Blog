<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 py-8">
        <!-- Page Heading -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800"><i class="fa-solid fa-pen-to-square"></i> Update Blog</h2>
            <a href="{{ route('blog.index') }}"
                class="px-4 py-2 bg-gray-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-gray-700 transition">
                ← Back to Blogs
            </a>
        </div>

        <!-- Form Container -->
        <div class="bg-white shadow-lg rounded-lg p-6 max-w-2xl mx-auto">
            <form action="{{ route('blog.update', $blog) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <!-- Title Field -->
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                    <input type="text" id="title" name="title" value="{{ $blog->title }}"
                        class="mt-1 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                        placeholder="Enter title">
                    @error('title')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description Field -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description:</label>
                    <textarea id="description" name="description" rows="4"
                        class="mt-1 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"
                        placeholder="Enter description">{{ $blog->description }}</textarea>
                    @error('description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Banner Image Preview -->
                <label class="block text-sm font-medium text-gray-700">Current Banner Image:</label>
                <div class="mb-6 bg-black rounded-lg min-w-[600px]">

                    <img src="{{ asset('storage/' . $blog->banner_image) }}" alt="Banner Image"
                        class="w-full h-60 object-contain rounded-lg shadow-md">
                </div>
                <!-- Banner Image Upload -->
                <div class="mb-4">
                    <label for="banner_image" class="block text-sm font-medium text-gray-700">Upload New Banner
                        Image:</label>
                    <input type="file" id="banner_image" name="banner_image"
                        class="mt-1 p-2 w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select id="category_id" name="category_id"
                        class="mt-1 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $blog->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
                    <select id="status" name="status"
                        class="mt-1 p-3 w-full border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">
                        <option value="public" {{ $blog->status === 'public' ? 'selected' : '' }}>Public</option>
                        <option value="private" {{ $blog->status === 'private' ? 'selected' : '' }}>Private</option>
                        {{-- <option value="must-paid" {{ $blog->status === 'must-paid' ? 'selected' : '' }}>Must Paid</option> --}}
                    </select>
                </div>
                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full border border-black text-black py-3 rounded-lg font-semibold shadow-md hover:bg-gray-300 hover:text-white transition bg-white">
                        <i class="fa-solid fa-check"></i> Update Blog
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
