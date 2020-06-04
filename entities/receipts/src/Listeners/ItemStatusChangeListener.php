<?php

namespace InetStudio\ReceiptsContest\Receipts\Listeners;

use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Exception\BadResponseException;
use InetStudio\ReceiptsContest\Receipts\Contracts\Listeners\ItemStatusChangeListenerContract;

/**
 * Class ItemStatusChangeListener.
 */
class ItemStatusChangeListener implements ItemStatusChangeListenerContract
{
    /**
     * Заголовки писем.
     *
     * @var array
     */
    protected $subjects = [
        'moderation' => 'Ваш чек отправлен на проверку',
        'approved' => 'Ваш чек одобрен',
        'rejected' => 'Ваш чек отклонен',
    ];

    /**
     * Handle the event.
     *
     * @param  object  $event
     */
    public function handle($event): void
    {
        $item = $event->item;
        $statusAlias = $item->status->alias;

        $email = $item->getJSONData('additional_info', 'email');
        $name = $item->getJSONData('additional_info', 'name').' '.$item->getJSONData('additional_info', 'surname');

        $subject = $this->subjects[$statusAlias] ?? '';

        try {
            Mail::send(
                'admin.module.receipts-contest.receipts::mails.'.$statusAlias, compact('name'),
                function ($m) use ($email, $name, $subject) {
                    $m->from(config('mail.from.address'), config('mail.from.name'));

                    $m->to($email, $name)->subject($subject);
                }
            );
        } catch (BadResponseException $e) {
        }
    }
}
