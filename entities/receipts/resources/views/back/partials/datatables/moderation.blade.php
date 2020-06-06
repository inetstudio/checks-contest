@inject('statusesService', 'InetStudio\ReceiptsContest\Statuses\Contracts\Services\Back\ItemsServiceContract')

@php
    $statuses = $statusesService->getModel()->all();
    $setReasonStatuses = $statusesService->getItemsByType('reason');
@endphp

<div class="btn-group">
    <button data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle" aria-expanded="false">Статус</button>
    <ul class="dropdown-menu">
        @foreach ($statuses as $status)
            @if ($status['alias'] != $item['status']['alias'])
                <li>
                    <a class="receipt-moderate" href="{{ route('back.receipts-contest.receipts.moderate') }}" data-id="{{ $item['id'] }}" data-status_id="{{ $status['id'] }}" {{ ($setReasonStatuses->keyBy('alias')->has($status['alias'])) ? 'data-reason' : '' }}>
                        {{ $status['name'] }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>

    @php
        $icon = 'receipt';

        if ($item['fnsReceipt']) {
            $icon = 'qrcode';
        }
    @endphp
    <button class="btn btn-default show-receipt" type="button" data-url="{{ route('back.receipts-contest.receipts.show', [$item['id']]) }}">
        <i class="fa fa-{{ $icon }}"></i>
    </button>
</div>
