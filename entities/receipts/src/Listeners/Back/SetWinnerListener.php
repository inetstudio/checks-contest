<?php

namespace InetStudio\ReceiptsContest\Receipts\Listeners\Back;

use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Exception\BadResponseException;
use InetStudio\ReceiptsContest\Receipts\Contracts\Listeners\Back\SetWinnerListenerContract;

class SetWinnerListener implements SetWinnerListenerContract
{
    public function handle($event): void
    {
        $item = $event->item;
        $prize = $event->prize;

        $email = $item->getJSONData('additional_info', 'email');
        $name = trim($item->getJSONData('additional_info', 'name').' '.$item->getJSONData('additional_info', 'surname'));

        $subject = 'Вы выиграли приз';

        try {
            Mail::send(
                'admin.module.receipts-contest.receipts::mails.win', compact('name', 'prize'),
                function ($m) use ($email, $name, $subject) {
                    $m->from(config('mail.from.address'), config('mail.from.name'));

                    $m->to($email, $name)->subject($subject);
                }
            );
        } catch (BadResponseException $e) {
        }
    }
}
