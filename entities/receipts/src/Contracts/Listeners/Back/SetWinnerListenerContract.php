<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Listeners\Back;

interface SetWinnerListenerContract
{
    public function handle($event): void;
}
