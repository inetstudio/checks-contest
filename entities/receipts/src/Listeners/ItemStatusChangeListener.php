<?php

namespace InetStudio\ReceiptsContest\Receipts\Listeners;

use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Exception\BadResponseException;
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

        try {
            Mail::send(
                'admin.module.receipts-contest.receipts::mails.status.'.$statusAlias, compact('name'),
                function ($m) use ($email, $name, $subject) {
                    $m->from(config('mail.from.address'), config('mail.from.name'));

                    $m->to($email, $name)->subject($subject);
                }
            );
        } catch (BadResponseException $e) {
        }
    }
}
