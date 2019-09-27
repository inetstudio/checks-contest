@inject('statusesService', 'InetStudio\ChecksContest\Statuses\Contracts\Services\Back\ItemsServiceContract')

@php
    $statuses = $statusesService->getAllItems()->pluck('name', 'alias')->toArray()
@endphp

<div class="btn-group">
    <button data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle" aria-expanded="false">Статус</button>
    <ul class="dropdown-menu">
        @foreach ($statuses as $statusAlias => $statusName)
            @if ($statusAlias != $item['status']['alias'])
                <li>
                    <a class="check-moderate"
                       href="{{ route('back.checks-contest.checks.moderate', ['id' => $item['id'], 'statusAlias' => $statusAlias]) }}">{{ $statusName }}</a>
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
    <button class="btn btn-default show-receipts" type="button" data-url="{{ route('back.checks-contest.checks.show', [$item['id']]) }}">
        <i class="fa fa-{{ $icon }}"></i>
    </button>
</div>
