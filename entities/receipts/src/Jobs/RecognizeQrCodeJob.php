<?php

namespace InetStudio\ReceiptsContest\Receipts\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use InetStudio\ReceiptsContest\Receipts\Contracts\Models\ReceiptModelContract;
use InetStudio\ReceiptsContest\Receipts\DTO\Back\Items\AddBarcodes\ItemData as AddBarcodesData;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract as ReceiptsServiceContract;

final class RecognizeQrCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ReceiptModelContract $receipt;

    protected ReceiptsServiceContract $receiptsService;

    public int $tries = 65;

    public function __construct(ReceiptModelContract $receipt)
    {
        $this->receipt = $receipt->fresh(['status']);
    }

    public function handle(ReceiptsServiceContract $receiptsService)
    {
        $this->receiptsService = $receiptsService;

        if ($this->receipt->status->alias === 'rejected') {
            return;
        }

        try {
            $this->recognizeCodes();
        } catch (ServerException $exception) {
            if ($this->attempts() === 60) {
                return;
            }

            return $this->release(60);
        }
    }

    protected function recognizeCodes(): void
    {
        $imagePath = $this->receipt->getFirstMediaPath('images');

        if (! $imagePath || ! file_exists($imagePath)) {
            return;
        }

        $codes = $this->getBarcodes($imagePath);

        $this->setBarcodes($codes);
    }

    protected function getBarcodes(string $imagePath): array
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            config('services.recognize_barcodes_api.url'),
            [
                'headers' => [
                    'Authorization' => 'Bearer '.config('services.recognize_barcodes_api.token'),
                    'Accept' => 'application/json',
                ],
                'multipart' => [
                    [
                        'name' => 'image',
                        'contents' => file_get_contents($imagePath),
                        'filename' => $imagePath
                    ],
                ],
            ]
        );

        return json_decode($response->getBody()->getContents(), true);
    }

    protected function setBarcodes(array $codes): void
    {
        $data = new AddBarcodesData(
            [
                'id' => $this->receipt->id,
                'receipt_data' => [
                    'codes' => $codes,
                ],
            ]
        );

        $this->receiptsService->addBarcodes($data);
    }
}
