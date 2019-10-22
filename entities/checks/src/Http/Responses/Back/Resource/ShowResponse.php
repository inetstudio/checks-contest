<?php

namespace InetStudio\ChecksContest\Checks\Http\Responses\Back\Resource;

use League\Fractal\Manager;
use League\Fractal\Resource\Item as FractalItem;
use InetStudio\AdminPanel\Base\Http\Responses\BaseResponse;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\AdminPanel\Base\Contracts\Serializers\SimpleDataArraySerializerContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Resource\ShowResponseContract;
use InetStudio\ChecksContest\Checks\Contracts\Transformers\Back\Resource\ShowTransformerContract;

/**
 * Class ShowResponse.
 */
class ShowResponse extends BaseResponse implements ShowResponseContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $resourceService;

    /**
     * @var ShowTransformerContract
     */
    protected $transformer;

    /**
     * @var SimpleDataArraySerializerContract
     */
    protected $serializer;

    /**
     * FormResponse constructor.
     *
     * @param  ItemsServiceContract  $resourceService
     * @param  ShowTransformerContract  $transformer
     * @param  SimpleDataArraySerializerContract  $serializer
     */
    public function __construct(
        ItemsServiceContract $resourceService,
        ShowTransformerContract $transformer,
        SimpleDataArraySerializerContract $serializer
    ) {
        $this->resourceService = $resourceService;

        $this->transformer = $transformer;
        $this->serializer = $serializer;

        $this->render = true;
        $this->view = 'admin.module.checks-contest.checks::back.modals.receipts-body';
    }

    /**
     * Prepare response data.
     *
     * @param $request
     *
     * @return array
     */
    protected function prepare($request): array
    {
        $id = $request->route('check', 0);

        $item = $this->resourceService->getItemById($id);
        $item = $this->transformData($item);

        return compact('item');
    }

    /**
     * @param  CheckModelContract  $item
     *
     * @return array
     */
    protected function transformData(CheckModelContract $item): array
    {
        $resource = new FractalItem($item, $this->transformer);

        $manager = new Manager();
        $manager->setSerializer($this->serializer);
        $transformation = $manager->createData($resource)->toArray();

        return $transformation;
    }
}
