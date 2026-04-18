<?php

namespace App\Notifications;

use App\Models\UserChallenge;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewChallengeNotification extends Notification
{
    use Queueable;

    public function __construct(public UserChallenge $userChallenge) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title'       => '🏃 Tantangan Baru Hari Ini!',
            'body'        => $this->userChallenge->challenge->title,
            'description' => $this->userChallenge->challenge->description,
            'url'         => route('health-challenge.index'),
            'points'      => $this->userChallenge->challenge->points,
        ];
    }
}

