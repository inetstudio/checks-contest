<?php

declare(strict_types=1);

namespace InetStudio\ReceiptsContest\Receipts\DTO\Front;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\DataTransferObject;
use InetStudio\ReceiptsContest\Receipts\Contracts\DTO\Front\SendItemDataContract;

class SendItemData extends DataTransferObject implements SendItemDataContract
{
    public string $verify_hash;

    public array $additional_info;

    public int $user_id;

    public int $status_id;

    public ?UploadedFile $image;

    public static function fromRequest(Request $request): self
    {
        $statusesService = resolve(
            'InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract'
        );

        $status = $statusesService->getItemsByType('default')->first();

        $additionalData = $request->input('additional_info', []);
        $additionalData['personal']['phone'] = str_replace(['+', '-', '(', ')', ' '], '', $additionalData['personal']['phone']);
        array_walk_recursive($additionalData, fn(&$value) => $value = trim(str_replace('&nbsp;', ' ', strip_tags($value))));

        return new self([
            'verify_hash' => md5(time().json_encode($request->all())),
            'additional_info' => $additionalData,
            'user_id' => Auth::id() ?? 0,
            'status_id' => $status['id'] ?? 0,
            'image' => $request->file('receipt_image'),
        ]);
    }
}
