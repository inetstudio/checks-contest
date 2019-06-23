<?php

namespace InetStudio\ChecksContest\Checks\Listeners\Back;

use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Exception\BadResponseException;
use InetStudio\ChecksContest\Checks\Contracts\Listeners\Back\SetWinnerListenerContract;

/**
 * Class SetWinnerListener.
 */
class SetWinnerListener implements SetWinnerListenerContract
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     */
    public function handle($event): void
    {
        $check = $event->check;
        $prize = $event->prize;

        $email = $check->additional_info['email'];
        $name = $check->additional_info['name'].' '.$check->additional_info['surname'];

        $subject = 'Вы выиграли приз';

        try {
            Mail::send(
                'admin.module.checks-contest.checks::mails.win', compact('name', 'prize'),
                function ($m) use ($email, $name, $subject) {
                    $m->from(config('mail.from.address'), config('mail.from.name'));

                    $m->to($email, $name)->subject($subject);
                }
            );
        } catch (BadResponseException $e) {
        }
    }
}
