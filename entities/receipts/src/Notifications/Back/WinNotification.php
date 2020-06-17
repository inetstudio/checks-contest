<?php

namespace InetStudio\ReceiptsContest\Receipts\Notifications\Back;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use InetStudio\ReceiptsContest\Receipts\Contracts\Mail\Back\WinMailContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Notifications\Back\WinNotificationContract;

class WinNotification extends Notification implements WinNotificationContract
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

    public function toMail($notifiable): WinMailContract
    {
        $mail = resolve(WinMailContract::class, $this->data);

        return $mail->to($notifiable->routeNotificationFor('mail'));
    }
}
