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
        $buttonClass = 'default';

        if (count($item['fnsReceipts']) > 0) {
            $buttonClass = 'primary';
        } elseif (count($item['products']) > 0) {
            $buttonClass = 'warning';
        }
    @endphp
    <button class="btn btn-{{ $buttonClass }} show-receipts" type="button" data-url="{{ route('back.checks-contest.checks.show', [$item['id']]) }}">
        <i class="fa fa-receipt"></i>
    </button>
</div>
