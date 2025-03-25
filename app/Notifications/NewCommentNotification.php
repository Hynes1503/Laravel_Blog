<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Comment;

class NewCommentNotification extends Notification
{
    use Queueable;

    protected $comment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Determine how notifications should be stored.
     */
    public function via($notifiable)
    {
        return ['database']; // Lưu vào database
    }

    /**
     * Get the array representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => "Có người đã bình luận vào bài viết của bạn: '{$this->comment->content}'",
            'blog_id' => $this->comment->blog_id,
        ];
    }
}
