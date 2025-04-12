<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 py-8">
        <!-- Page Heading -->
        <div class="flex justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 flex items-center space-x-2">
                    <i class="fa-solid fa-blog"></i>
                    <span>Blog Details</span>
                </h2>
                @if (auth()->id() === $blog->user_id)
                    <div class="flex flex-col items-start space-y-4 mt-6 ml-6">
                        <a href="{{ route('blog.edit', $blog) }}"
                            class="px-4 py-2 border border-black text-black text-sm font-semibold rounded-lg shadow-md hover:bg-gray-300 hover:text-white transition">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Blog
                        </a>

                        <form action="{{ route('blog.destroy', $blog) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này không?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-red-700 transition">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>


            <!-- Blog Details Card -->
            <div class="bg-white shadow-lg rounded-lg p-6 max-w-2xl mx-auto">
                <div class="flex justify-between items-center">
                    <a href="{{ route('author.index', $blog->user->id) }}">
                        <i class="fa-solid fa-user"></i> {{ $blog->user->name }}
                    </a>
                    <!-- Nút Report Blog -->
                    @auth
                        @if (auth()->id() !== $blog->user_id && !$blog->reported)
                            <form action="{{ route('blog.report', $blog->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                    onclick="return confirm('Are you sure you want to report this post?');">
                                    Report
                                </button>
                            </form>
                        {{-- @elseif ($blog->reported)
                            <span class="ml-4 text-red-500">Đã báo cáo</span> --}}
                        @endif
                    @endauth
                </div>
                <h2 class="text-gray-900">{{ $blog->title }}</h2>
                <p class="text-xs ">{{ $blog->created_at->format('d M, Y') }}</p>
                <p class="break-words">
                    <span class="short-text">
                        {{ Str::limit($blog->description, 140, '...') }}
                    </span>
                    <span class="full-text hidden">
                        {{ $blog->description }}
                    </span>
                    @if (strlen($blog->description) > 140)
                        <button
                            class="toggle-btn text-black text-sm mt-2 bg-transparent border-none outline-none underline"><span
                                x-show="!expanded">Xem thêm</span>
                        </button>
                    @endif
                </p>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.querySelectorAll(".toggle-btn").forEach(button => {
                            button.addEventListener("click", function() {
                                let parent = this.parentElement;
                                let shortText = parent.querySelector(".short-text");
                                let fullText = parent.querySelector(".full-text");

                                if (shortText.classList.contains("hidden")) {
                                    shortText.classList.remove("hidden");
                                    fullText.classList.add("hidden");
                                    this.textContent = "Xem thêm";
                                } else {
                                    shortText.classList.add("hidden");
                                    fullText.classList.remove("hidden");
                                    this.textContent = "Thu gọn";
                                }
                            });
                        });
                    });
                </script>

                <!-- Banner Image -->
                <div class="mb-6 bg-black rounded-lg min-w-[600px]">
                    <img src="{{ asset('storage/' . $blog->banner_image) }}" alt="Banner Image"
                        class="w-full h-60 object-contain rounded-lg shadow-md">
                </div>
                @if (!empty($category))
                    <a href="{{ route('user.category.index', $category->id) }}">
                        <i class="fa-solid fa-tag"></i> {{ $category->name }}
                    </a>
                @endif
                <hr class="my-4 border-gray-300">
                <form method="POST" action="{{ route('blog.favorite', $blog->id) }}">
                    @csrf
                    <div class="flex items-center space-x-4 justify-between">
                        <div class="flex items-center space-x-4">
                            <button type="submit" class="px-2 py-1 bg-transparent text-black hover:underline">
                                @if ($blog->isFavoritedBy(auth()->user()))
                                    <i class="fa-solid fa-heart"></i> Dislike
                                @else
                                    <i class="fa-regular fa-heart"></i> Like
                                @endif
                            </button>
                            <p class="m-0">{{ $blog->favoritesCount() }}</p>
                        </div>
                        {{-- <div class="fb-share-button " data-href="{{ url()->route('blog.show', $blog->id) }}"
                            data-layout="button_count" data-size="small">
                        </div> --}}
                    </div>
                </form>

                <div class="max-w-2xl mx-auto mt-6">
                    <h3 class="text-lg font-semibold text-gray-800">Comments ({{ $blog->comments->count() }})</h3>

                    <div x-data="{ showAll: false }">
                        @foreach ($blog->comments->take(2) as $comment)
                            <div class="mt-4 p-4 bg-gray-100 rounded-lg" x-data="{ editMode: null }">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-gray-700">{{ $comment->user->name }}</h3>
                                    @auth
                                        @if (auth()->id() !== $comment->user_id && !$comment->reported)
                                            <form action="{{ route('comment.report', $comment->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                                    onclick="return confirm('Are you sure you want to report this comment?');">
                                                    Report
                                                </button>
                                            </form>
                                        {{-- @elseif ($comment->reported)
                                            <span class="ml-4 text-red-500">Đã báo cáo</span> --}}
                                        @endif
                                    @endauth
                                </div>

                                <p class="text-gray-700" x-show="editMode !== {{ $comment->id }}">
                                    <span x-data="{ expanded: false }">
                                        <span x-show="!expanded">
                                            {{ Str::limit($comment->content, 100, '...') }}
                                        </span>
                                        <span x-show="expanded">
                                            {{ $comment->content }}
                                        </span>
                                        @if (Str::length($comment->content) > 100)
                                            <button @click="expanded = !expanded"
                                                class="text-black text-sm mt-2 bg-transparent border-none outline-none">
                                                <span x-show="!expanded">View more</span>
                                                <span x-show="expanded">Collapse</span>
                                            </button>
                                        @endif
                                    </span>
                                </p>

                                <p class="text-sm text-gray-500 text-right">{{ $comment->created_at->diffForHumans() }}
                                </p>

                                @if (Auth::id() === $comment->user_id)
                                    <div x-show="editMode !== {{ $comment->id }}">
                                        <button @click="editMode = {{ $comment->id }}"
                                            class="px-2 py-1 bg-transparent text-black text-xs hover:underline">Edit</button>
                                        <form action="{{ route('comment.destroy', $comment->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa không?')"
                                                class="px-2 py-1 bg-transparent text-black text-xs hover:underline">Delete</button>
                                        </form>
                                    </div>

                                    <!-- Form chỉnh sửa bình luận -->
                                    <form action="{{ route('comment.update', $comment->id) }}" method="POST"
                                        x-show="editMode === {{ $comment->id }}" class="mt-2">
                                        @csrf
                                        @method('PUT')
                                        <textarea name="content" class="w-full p-2 border rounded">{{ $comment->content }}</textarea>
                                        <div class="mt-2">
                                            <button type="submit"
                                                class="px-2 py-1 bg-transparent text-black text-xs hover:underline">Update</button>
                                            <button type="button" @click="editMode = null"
                                                class="px-2 py-1 bg-transparent text-black text-xs hover:underline">Cancel</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                        <template x-if="showAll">
                            <div>
                                @foreach ($blog->comments->skip(2) as $comment)
                                    <div class="mt-4 p-4 bg-gray-100 rounded-lg">
                                        <h3 class="text-gray-700">{{ $comment->user->name }}</h3>
                                        <p class="text-gray-700">{{ $comment->content }}</p>
                                        <p class="text-sm text-gray-500 text-right">
                                            {{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </template>

                        @if ($blog->comments->count() > 2)
                            <button @click="showAll = !showAll"
                                class="text-black text-sm mt-2 bg-transparent border-none outline-none">
                                <span x-show="!showAll">View more</span>
                                <span x-show="showAll">Collapse</span>
                            </button>
                        @endif
                    </div>

                </div>
                @auth
                    <div class="max-w-2xl mx-auto mt-6 bg-white p-4 rounded-lg shadow">
                        <form action="{{ route('comments.store', $blog) }}" method="POST">
                            @csrf
                            <textarea name="content" class="w-full p-2 border rounded-lg"
                                placeholder="Comment as user {{ auth()->user()->name }}" required></textarea>
                            <button type="submit"
                                class="px-4 py-2 border border-black text-black text-sm font-semibold rounded-lg shadow-md hover:bg-transparent hover:text-black transition bg-white">
                                Comment
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
            <div class="max-w-2xl mx-auto mt-4">
                <a href="{{ url()->previous() }}"
                    class="px-2 py-2 bg-gray-600 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 transition">
                    <i class="fa-solid fa-arrow-left"></i>Back
                </a>
            </div>
        </div>


    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.onbeforeunload = function() {
                fetch('/laravel/demo/public/blogs/{{ $blog->id }}/track-view-time', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                });
            };
        });
    </script>
</x-app-layout>
