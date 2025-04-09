<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BlogCommented extends Notification
{
    use Queueable;

    protected $blog;
    protected $commenter;
    protected $comment;

    public function __construct($blog, $commenter, $comment)
    {
        $this->blog = $blog;
        $this->commenter = $commenter;
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "{$this->commenter->name} commented on your blog '{$this->blog->title}': '{$this->comment->content}'",
            'blog_id' => $this->blog->id,
            'commenter_id' => $this->commenter->id,
            'comment_id' => $this->comment->id,
        ];
    }
}