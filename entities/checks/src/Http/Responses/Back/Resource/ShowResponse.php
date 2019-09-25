<?php

namespace InetStudio\ChecksContest\Checks\Http\Responses\Back\Resource;

use Throwable;
use Illuminate\Http\Request;
use InetStudio\ChecksContest\Checks\Contracts\Models\CheckModelContract;
use InetStudio\ChecksContest\Checks\Contracts\Http\Responses\Back\Resource\ShowResponseContract;

/**
 * Class ShowResponse.
 */
class ShowResponse implements ShowResponseContract
{
    /**
     * @var CheckModelContract
     */
    protected $item;

    /**
     * ShowResponse constructor.
     *
     * @param  CheckModelContract  $item
     */
    public function __construct(CheckModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * @param  Request  $request
     *
     * @return array|string|\Symfony\Component\HttpFoundation\Response
     *
     * @throws Throwable
     */
    public function toResponse($request)
    {
        return view(
            'admin.module.checks-contest.checks::back.modals.receipts-body',
            ['item' => $this->item]
        )->render();
    }
}
