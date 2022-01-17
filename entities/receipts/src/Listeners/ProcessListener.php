<?php

namespace InetStudio\ReceiptsContest\Receipts\Listeners;

use Illuminate\Support\Facades\Bus;
use InetStudio\ReceiptsContest\Receipts\Jobs\AttachProductsJob;
use InetStudio\ReceiptsContest\Receipts\Jobs\ModerateBuyDateJob;
use InetStudio\ReceiptsContest\Receipts\Jobs\RecognizeQrCodeJob;
use InetStudio\ReceiptsContest\Receipts\Jobs\AttachFnsReceiptJob;
use InetStudio\ReceiptsContest\Receipts\Jobs\MoveToModerationJob;
use InetStudio\ReceiptsContest\Receipts\Jobs\ModerateReceiptSumJob;
use InetStudio\ReceiptsContest\Receipts\Jobs\ModerateUploadDateJob;
use InetStudio\ReceiptsContest\Receipts\Jobs\ModerateReceiptUserJob;
use InetStudio\ReceiptsContest\Receipts\Jobs\ModerateFnsDuplicatesJob;
use InetStudio\ReceiptsContest\Receipts\Jobs\ModerateQrCodesDuplicatesJob;

class ProcessListener
{
    public function handle($event): void
    {
        $receipt = $event->item;

        if ($receipt->status->alias === 'processing') {
            Bus::chain([
                new ModerateUploadDateJob($receipt),
                new RecognizeQrCodeJob($receipt),
                new ModerateQrCodesDuplicatesJob($receipt),
                new AttachFnsReceiptJob($receipt),
                new ModerateBuyDateJob($receipt),
                new ModerateReceiptSumJob($receipt),
                new ModerateFnsDuplicatesJob($receipt),
                new ModerateReceiptUserJob($receipt),
                new AttachProductsJob($receipt),
                new MoveToModerationJob($receipt)
            ])->dispatch();
        }
    }
}
