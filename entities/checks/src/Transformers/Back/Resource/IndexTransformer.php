<?php

namespace InetStudio\ChecksContest\Checks\Transformers\Back\Resource;

use Throwable;
use League\Fractal\TransformerAbstract;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Transformers\Back\Resource\IndexTransformerContract;

/**
 * Class IndexTransformer.
 */
class IndexTransformer extends TransformerAbstract implements IndexTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  CheckModelContract  $item
     *
     * @return array
     *
     * @throws Throwable
     */
    public function transform(CheckModelContract $item): array
    {
        $receiptData = $item['receipt_data'];
        $userData = $item['additional_info'];

        return [
            'id' => $item['id'],
            'receipt_data' => $receiptData,
            'fnsReceipt' => $item['fnsReceipt']['receipt'],
            'additional_info' => $userData,
            'status' => view(
                'admin.module.checks-contest.checks::back.partials.datatables.status', [
                'item' => $item['status'],
            ]
            )->render(),
            'moderation' => view(
                'admin.module.checks-contest.checks::back.partials.datatables.moderation', compact('item')
            )->render(),
            'prizes' => view(
                'admin.module.checks-contest.checks::back.partials.datatables.prizes',
                [
                    'prizes' => $item['prizes'],
                ]
            )->render(),
            'check' => view('admin.module.checks-contest.checks::back.partials.datatables.check', compact('item'))
                ->render(),
            'name' => $userData['name'] ?? '',
            'surname' => $userData['surname'] ?? '',
            'email' => $userData['email'] ?? '',
            'phone' => $userData['phone'] ?? '',
            'created_at' => (string) $item['created_at'],
            'updated_at' => (string) $item['updated_at'],
            'actions' => view('admin.module.checks-contest.checks::back.partials.datatables.actions', compact('item'))
                ->render(),
        ];
    }
}
