<?php

namespace InetStudio\ReceiptsContest\Prizes\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\FlexibleDataTransferObject;
use InetStudio\ReceiptsContest\Prizes\Contracts\DTO\ItemDataContract;

class ItemData extends FlexibleDataTransferObject implements ItemDataContract
{
    public int $id = 0;

    public string $name;

    public string $alias;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'id' => (int) $request->input('id'),
            'name' => trim(strip_tags($request->input('name'))),
            'alias' => trim(strip_tags($request->input('alias'))),
        ]);
    }
}
