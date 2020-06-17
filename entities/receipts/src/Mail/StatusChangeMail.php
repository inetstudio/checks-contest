<?php

namespace InetStudio\ReceiptsContest\Receipts\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use InetStudio\ReceiptsContest\Receipts\Contracts\Mail\StatusChangeMailContract;

class StatusChangeMail extends Mailable implements StatusChangeMailContract
{
    use SerializesModels;

    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build(): self
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject($this->data['subject'])
            ->view('admin.module.checks-contest.checks::mails.moderation.'.$this->data['statusAlias'], $this->data);
    }
}
