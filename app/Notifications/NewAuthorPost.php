<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAuthorPost extends Notification
{
    use Queueable;

    public $post;

    /**
     * Create a new notification instance.
     */
    public function __construct($post)
    {
        $this->post=$post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                ->greeting('Hello', 'Admin')
                ->subject('New Post Approval Needed')
                ->line('New Post By '.$this->post->user->name. 'Need to approve')
                ->line('To Approve the post click vew Button')
                ->line('Post Title :' .$this->post->title)
                ->action('View', url(route('admin.post.show',$this->post->id)))
                ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
