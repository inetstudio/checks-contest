<?php

namespace InetStudio\ReceiptsContest\Statuses\Http\Resources\Back\Utility\Suggestions;

use Illuminate\Http\Resources\Json\ResourceCollection;
use InetStudio\ReceiptsContest\Statuses\Contracts\Http\Resources\Back\Utility\Suggestions\ItemsCollectionContract;

class ItemsCollection extends ResourceCollection implements ItemsCollectionContract
{
    protected string $type;

    public function __construct($resource, string $type = '')
    {
        $this->type = $type;

        if ($type == 'autocomplete') {
            $itemResource = app()->make(
                'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Resources\Back\Utility\Suggestions\AutocompleteItemResourceContract',
                [
                    'resource' => null,
                ]
            );
        } else {
            $itemResource = app()->make(
                'InetStudio\ReceiptsContest\Statuses\Contracts\Http\Resources\Back\Utility\Suggestions\ItemResourceContract',
                [
                    'resource' => null,
                ]
            );
        }

        $this->collects = get_class($itemResource);

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            ($this->type == 'autocomplete') ? 'suggestions' : 'items' => $this->collection,
        ];
    }
}
