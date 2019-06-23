<?php

namespace InetStudio\ChecksContest\Statuses\Transformers\Back\Utility;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\ChecksContest\Statuses\Contracts\Models\StatusModelContract;
use InetStudio\ChecksContest\Statuses\Contracts\Transformers\Back\Utility\SuggestionTransformerContract;

/**
 * Class SuggestionTransformer.
 */
class SuggestionTransformer extends TransformerAbstract implements SuggestionTransformerContract
{
    /**
     * @var string
     */
    protected $type;

    /**
     * SuggestionTransformer constructor.
     *
     * @param  string  $type
     */
    public function __construct(string $type = '')
    {
        $this->type = $type;
    }

    /**
     * Подготовка данных для отображения в выпадающих списках.
     *
     * @param  StatusModelContract  $item
     *
     * @return array
     */
    public function transform(StatusModelContract $item): array
    {
        return ($this->type == 'autocomplete')
            ? [
                'value' => $item['name'],
                'data' => [
                    'id' => $item['id'],
                    'type' => get_class($item),
                    'title' => $item['name'],
                ],
            ]
            : [
                'id' => $item['id'],
                'name' => $item['name'],
            ];
    }

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection
    {
        return new FractalCollection($items, $this);
    }
}
