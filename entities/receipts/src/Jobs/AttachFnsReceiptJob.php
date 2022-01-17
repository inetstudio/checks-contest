<?php

namespace InetStudio\ReceiptsContest\Receipts\Jobs;

use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\Fns\Receipts\Contracts\Models\ReceiptModelContract as FnsReceiptModelContract;
use InetStudio\Fns\Receipts\Contracts\Services\ItemsServiceContract as FnsReceiptsServiceContract;
use InetStudio\ReceiptsContest\Receipts\DTO\Back\Items\AttachFnsReceipt\ItemData as AttachFnsReceiptData;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract as ReceiptsServiceContract;

final class AttachFnsReceiptJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ReceiptModelContract $receipt;

    protected ReceiptsServiceContract $receiptsService;

    protected FnsReceiptsServiceContract $fnsReceiptsService;

    public int $tries = 3;

    public function __construct(ReceiptModelContract $receipt)
    {
        $this->receipt = $receipt->fresh(['status']);
    }

    public function handle(
        ReceiptsServiceContract $receiptsService,
        FnsReceiptsServiceContract $fnsReceiptsService
    ) {
        $this->receiptsService = $receiptsService;
        $this->fnsReceiptsService = $fnsReceiptsService;

        if ($this->receipt->status->alias === 'rejected') {
            return;
        }

        $codes = $this->receipt->getJSONData('receipt_data', 'codes', []);

        if (empty($codes)) {
            return;
        }

        try {
            $this->attachFnsReceipt($codes);

            $this->receipt = $this->receipt->fresh(['status', 'fnsReceipt']);

            if (! $this->receipt->fnsReceipt) {
                if ($this->attempts() >= 2) {
                    return;
                }

                return $this->release(1800);
            }
        } catch (ServerException $exception) {
            if ($this->attempts() >= 2) {
                return;
            }

            return $this->release(1800);
        }
    }

    protected function attachFnsReceipt(array $codes): void
    {
        $fnsReceipt = null;

        foreach ($codes as $code) {
            if (! (($code['type'] ?? '') === 'QR_CODE')) {
                continue;
            }

            if (! ($code['value'] ?? '')) {
                continue;
            }

            if (Str::startsWith($code['value'], 'http')) {
                continue;
            }

            $fnsReceipt = null;

            $fnsReceiptData = $this->getFnsReceiptData($code['value']);

            if (isset($fnsReceiptData['receipt'])) {
                $fnsReceipt = $this->saveFnsReceipt($fnsReceiptData);

                break;
            }
        }

        $data = new AttachFnsReceiptData(
            [
                'id' => $this->receipt->id,
                'fns_receipt_id' => $fnsReceipt->id ?? null
            ]
        );

        $this->receiptsService->attachFnsReceipt($data);
    }

    protected function getFnsReceiptData(string $code): array
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            config('services.fns_api.url'),
            [
                'headers' => [
                    'Authorization' => 'Bearer '.config('services.fns_api.token'),
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'qr_code' => $code,
                ]
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    protected function saveFnsReceipt(array $fnsReceiptData): FnsReceiptModelContract
    {
        $data = resolve(
            'InetStudio\Fns\Receipts\Contracts\DTO\ItemDataContract',
            [
                'args' => [
                    'qr_code' => $fnsReceiptData['receipt']['qr_code'],
                    'hash' => md5(json_encode($fnsReceiptData['receipt']['data']['content'])),
                    'data' => $fnsReceiptData['receipt']['data'],
                ]
            ]
        );

        return $this->fnsReceiptsService->save($data);
    }
}
