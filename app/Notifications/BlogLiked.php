<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BlogLiked extends Notification
{
    use Queueable;

    protected $blog;
    protected $liker;

    public function __construct($blog, $liker)
    {
        $this->blog = $blog;
        $this->liker = $liker;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "{$this->liker->name} liked your blog '{$this->blog->title}'",
            'blog_id' => $this->blog->id,
            'liker_id' => $this->liker->id,
        ];
    }
}