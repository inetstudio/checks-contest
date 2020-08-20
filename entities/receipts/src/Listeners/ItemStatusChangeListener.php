<?php

namespace InetStudio\ReceiptsContest\Receipts\Listeners;

use Illuminate\Support\Facades\Notification;
use InetStudio\ReceiptsContest\Receipts\Contracts\Listeners\ItemStatusChangeListenerContract;

class ItemStatusChangeListener implements ItemStatusChangeListenerContract
{
    public function handle($event): void
    {
        $item = $event->item;
        $statusAlias = $item->status->alias;

        $email = $item->getJSONData('additional_info', 'email');
        $name = trim($item->getJSONData('additional_info', 'name').' '.$item->getJSONData('additional_info', 'surname'));
        $subject = config('receipts_contest_receipts.mails.status.'.$statusAlias.'.subject', '');

        $data = compact('subject', 'name', 'statusAlias');

        $notification = Notification::route('mail', $email);
        $notification->notify(resolve('InetStudio\ReceiptsContest\Receipts\Contracts\Notifications\StatusChangeNotificationContract', compact('data')));
    }
}
