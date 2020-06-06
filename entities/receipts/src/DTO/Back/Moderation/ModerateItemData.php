<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Receipts\DTO\Back\Moderation;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\Back\Moderation\ModerateItemDataContract;

class ModerateItemData extends FlexibleDataTransferObject implements ModerateItemDataContract
{
    public int $id;

    public int $status_id;

    public array $receipt_data;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'id' => $request->input('id'),
            'status_id' => $request->input('status_id'),
            'receipt_data' => $request->input('receipt_data', []),
        ]);
    }
}
