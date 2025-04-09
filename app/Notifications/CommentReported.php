<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CommentReported extends Notification
{
    use Queueable;

    protected $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "A comment by {$this->comment->user->name} on blog '{$this->comment->blog->title}' has been reported: '{$this->comment->content}'",
            'comment_id' => $this->comment->id,
            'blog_id' => $this->comment->blog->id,
        ];
    }
}