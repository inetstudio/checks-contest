<?php

namespace InetStudio\ReceiptsContest\Receipts\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use InetStudio\ReceiptsContest\Products\DTO\Back\Items\Attach\ItemData as ProductData;
use InetStudio\ReceiptsContest\Products\DTO\Back\Items\Attach\ItemsCollection as ProductsCollection;
use InetStudio\ReceiptsContest\Receipts\Contracts\Console\Commands\AttachFnsReceiptsCommandContract;
use InetStudio\Fns\Receipts\Contracts\Services\Back\ItemsServiceContract as FnsReceiptsServiceContract;
use InetStudio\ReceiptsContest\Receipts\DTO\Back\Items\AttachFnsReceipt\ItemData as AttachFnsReceiptData;
use InetStudio\ReceiptsContest\Products\Contracts\Services\Back\ItemsServiceContract as ProductsServiceContract;
use InetStudio\ReceiptsContest\Receipts\Contracts\Services\Back\ItemsServiceContract as ReceiptsServiceContract;
use InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract as StatusesServiceContract;

class AttachFnsReceiptsCommand extends Command implements AttachFnsReceiptsCommandContract
{
    protected $signature = 'inetstudio:receipts-contest:receipts:fns';

    protected $description = 'Attach FNS receipts to contest receipts';

    protected bool $useExternalService = false;

    protected StatusesServiceContract $statusesService;

    protected ReceiptsServiceContract $receiptsService;

    protected ProductsServiceContract $productsService;

    protected FnsReceiptsServiceContract $fnsReceiptsService;

    public function __construct(
        StatusesServiceContract $statusesService,
        ReceiptsServiceContract $receiptsService,
        ProductsServiceContract $productsService,
        FnsReceiptsServiceContract $fnsReceiptsService
    ) {
        parent::__construct();

        $this->statusesService = $statusesService;
        $this->receiptsService = $receiptsService;
        $this->productsService = $productsService;
        $this->fnsReceiptsService = $fnsReceiptsService;

        if (config('services.fns_api.url', '')) {
            $this->useExternalService = true;
        }
    }

    public function handle()
    {
        $statuses = $this->statusesService->getItemsByType('default');

        $receipts = $this->receiptsService->getItemsWithoutFnsReceiptByStatuses($statuses);

        $bar = $this->output->createProgressBar(count($receipts));

        foreach ($receipts as $receipt) {
            $codes = $receipt->getJSONData('receipt_data', 'codes', []);

            $products = new ProductsCollection();

            foreach ($codes as $code) {
                if (! (($code['type'] ?? '') === 'QR_CODE')) {
                    continue;
                }

                if (! ($code['value'] ?? '')) {
                    continue;
                }

                $fnsReceipt = null;

                if ($this->useExternalService) {
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
                                'qr_code' => $code['value'],
                            ]
                        ]
                    );

                    $fnsReceiptData = json_decode($response->getBody()->getContents(), true);

                    if (! empty($fnsReceiptData)) {
                        $fnsReceipt = $this->fnsReceiptsService->save($fnsReceiptData, 0);
                    }
                } else {
                    $fnsReceipt = $this->fnsReceiptsService->getReceiptByQrCode($code[1]);
                }

                if ($fnsReceipt) {
                    $fnsReceiptData = $fnsReceipt->receipt['document']['receipt'];

                    foreach ($fnsReceiptData['items'] ?? [] as $item) {
                        $products[] = new ProductData(
                            [
                                'receipt_id' => $receipt->id,
                                'fns_receipt_id' => $fnsReceipt->id,
                                'name' => $item['name'],
                                'quantity' => (float) $item['quantity'],
                                'price' => (int) $item['price'],
                                'product_data' => $item,
                            ]
                        );
                    }

                    break;
                }
            }

            $data = new AttachFnsReceiptData(
                [
                    'id' => $receipt['id'],
                    'receipt_id' => $fnsReceipt->id ?? 0
                ]
            );

            $this->receiptsService->attachFnsReceipt($data);
            $this->productsService->attach($receipt, $products);

            $bar->advance();
        }

        $bar->finish();
    }
}
