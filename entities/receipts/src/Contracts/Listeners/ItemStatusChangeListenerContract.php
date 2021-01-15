<?php

namespace InetStudio\ReceiptsContest\Receipts\Contracts\Listeners;

interface ItemStatusChangeListenerContract
{
    public function handle($event): void;
}
