<?php

namespace InetStudio\ReceiptsContest\Receipts\Mail\Back;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use InetStudio\ReceiptsContest\Receipts\Contracts\Mail\Back\WinMailContract;

class WinMail extends Mailable implements WinMailContract
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
            ->view('admin.module.receipts-contest.receipts::mails.win.'.$this->data['prize']['alias'], $this->data);
    }
}
