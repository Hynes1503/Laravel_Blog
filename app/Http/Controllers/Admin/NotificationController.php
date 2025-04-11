<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $notifications = $user->notifications()->paginate(10); // Lấy tất cả thông báo, phân trang 10 mỗi trang

        return view('admin.notification.index', compact('notifications'));
    }

    public function markAsRead(Request $request, $notificationId)
    {
        $user = $request->user();
        $notification = $user->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        return redirect()->route('admin.notification.index')->with('success', 'Notification marked as read');
    }

    public function destroy(Request $request, $notificationId)
    {
        $user = $request->user();
        $notification = $user->notifications()->findOrFail($notificationId);
        $notification->delete();

        return redirect()->route('admin.notification.index')->with('success', 'Notification deleted successfully');
    }

    // Thêm: Đánh dấu tất cả đã đọc
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();
        $user->unreadNotifications()->update(['read_at' => now()]);

        return redirect()->route('admin.notification.index')->with('success', 'All notifications marked as read');
    }

    // Thêm: Xóa tất cả
    public function destroyAll(Request $request)
    {
        $user = $request->user();
        $user->notifications()->delete();

        return redirect()->route('admin.notification.index')->with('success', 'All notifications deleted successfully');
    }
}
