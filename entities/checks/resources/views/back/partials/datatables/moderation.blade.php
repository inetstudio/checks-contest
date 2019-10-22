@inject('statusesService', 'InetStudio\ChecksContest\Statuses\Contracts\Services\Back\ItemsServiceContract')

@php
    $statuses = $statusesService->getAllItems()->get();
@endphp

<div class="btn-group">
    <button data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle" aria-expanded="false">Статус</button>
    <ul class="dropdown-menu">
        @foreach ($statuses as $status)
            @if ($status['alias'] != $item['status']['alias'])
                <li>
                    <a class="check-moderate" href="{{ route('back.checks-contest.checks.moderate', ['id' => $item['id'], 'statusAlias' => $status['alias']]) }}" {!! ($status['fill_reason']) ? 'data-reason' : '' !!}>{{ $status['name'] }}</a>
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
