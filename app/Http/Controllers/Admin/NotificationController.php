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
}
