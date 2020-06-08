<?php

namespace InetStudio\ReceiptsContest\Receipts\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use InetStudio\ReceiptsContest\Receipts\DTO\Back\Items\AddBarcodes\ItemData as AddBarcodesData;
use InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\RecognizeCodesCommandContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract as ReceiptsServiceContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract as StatusesServiceContract;

class RecognizeCodesCommand extends Command implements RecognizeCodesCommandContract
{
    protected $signature = 'inetstudio:receipts-contest:receipts:recognize-codes';

    protected $description = 'Recognize QR codes';

    protected bool $useExternalService = false;

    protected StatusesServiceContract $statusesService;

    protected ReceiptsServiceContract $receiptsService;

    public function __construct(StatusesServiceContract $statusesService, ReceiptsServiceContract $receiptsService)
    {
        parent::__construct();

        $this->statusesService = $statusesService;
        $this->receiptsService = $receiptsService;

        if (config('services.recognize_barcodes_api.url', '')) {
            $this->useExternalService = true;
        }
    }

    public function handle()
    {
        $statuses = $this->statusesService->getItemsByType('default');

        $receipts = $this->receiptsService->getItemsByStatuses($statuses);

        $bar = $this->output->createProgressBar(count($receipts));

        foreach ($receipts as $receipt) {
            if (! $receipt->hasJSONData('receipt_data', 'codes')) {
                $imagePath = $receipt->getFirstMediaPath('images');

                if (! $imagePath || ! file_exists($imagePath)) {
                    continue;
                }

                if ($this->useExternalService) {
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

                    $codes = json_decode($response->getBody()->getContents(), true);
                } else {
                    $codes = DecodeBarcodeFile($imagePath, 0x4000000);
                    $codes = (is_array($codes)) ? $codes : [];
                }

                $data = new AddBarcodesData(
                    [
                        'id' => $receipt['id'],
                        'receipt_data' => [
                            'codes' => $codes,
                        ],
                    ]
                );

                $this->receiptsService->addBarcodes($data);
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
