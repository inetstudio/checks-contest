<?php

namespace InetStudio\ReceiptsContest\Receipts\Listeners\Back;

use Illuminate\Support\Facades\Notification;
use InetStudio\ReceiptsContest\Receipts\Contracts\Listeners\Back\SetWinnerListenerContract;

class SetWinnerListener implements SetWinnerListenerContract
{
    public function handle($event): void
    {
        $item = $event->item;
        $prize = $event->prize;

        $email = $item->getJSONData('additional_info', 'email');
        $name = trim($item->getJSONData('additional_info', 'name').' '.$item->getJSONData('additional_info', 'surname'));
        $subject = config('receipts_contest_receipts.mails.win.'.$prize['alias'].'.subject', '');

        $data = compact('subject', 'name', 'prize');

        $notification = Notification::route('mail', $email);
        $notification->notify(resolve('InetStudio\ReceiptsContest\Receipts\Contracts\Notifications\Back\WinNotificationContract', compact('data')));
    }
}
