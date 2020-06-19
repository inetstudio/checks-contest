<?php

namespace InetStudio\ReceiptsContest\Receipts\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use InetStudio\ReceiptsContest\Receipts\Contracts\Mail\StatusChangeMailContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Notifications\StatusChangeNotificationContract;

class StatusChangeNotification extends Notification implements StatusChangeNotificationContract
{
    use Queueable;

    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): StatusChangeMailContract
    {
        $mail = resolve(StatusChangeMailContract::class, ['data' => $this->data]);

        return $mail->to($notifiable->routeNotificationFor('mail'));
    }
}
