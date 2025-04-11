@extends('admin.layouts.app')

@section('header')
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between w-full">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Notifications') }}
                </h2>
            </div>
        </div>
    </header>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fa-solid fa-bell"></i> All Notifications
            </h2>
            <div class="flex space-x-4">
                <!-- Nút đánh dấu tất cả đã đọc -->
                <form action="{{ route('admin.notification.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center space-x-2">
                        <i class="fa-solid fa-check-double"></i>
                        <span>Mark All as Read</span>
                    </button>
                </form>
                <!-- Nút xóa tất cả -->
                <form action="{{ route('admin.notification.destroyAll') }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete all notifications?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 flex items-center space-x-2">
                        <i class="fa-solid fa-trash-alt"></i>
                        <span>Delete All</span>
                    </button>
                </form>
            </div>
        </div>

        <table class="table w-full">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">Message</th>
                    <th scope="col">Time</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($notifications as $notification)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>
                            <a href="{{ $notification->data['blog_id'] ?? null ? route('admin.blog.show', $notification->data['blog_id']) : ($notification->data['user_id'] ?? null ? route('admin.user.show', $notification->data['user_id']) : '#') }}"
                                class="text-gray-700 hover:underline">
                                {{ $notification->data['message'] }}
                            </a>
                        </td>
                        <td>{{ $notification->created_at->diffForHumans() }}</td>
                        <td>
                            @if ($notification->read_at)
                                <span class="text-green-500 text-xs">Read</span>
                            @else
                                <span class="text-red-500 text-xs">Unread</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex justify-center items-center space-x-2 p-2">
                                @if (!$notification->read_at)
                                    <form action="{{ route('admin.notification.markAsRead', $notification->id) }}"
                                        method="POST" class="flex">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 bg-blue-600 rounded-md text-white hover:bg-blue-700">
                                            <i class="fa-solid fa-check"></i> Mark as Read
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.notification.destroy', $notification->id) }}"
                                    method="POST" class="flex"
                                    onsubmit="return confirm('Are you sure you want to delete this notification?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-600 rounded-md text-white hover:bg-red-700">
                                        <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">No notifications found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
@endsection