@if ($item['status'])
    <span class="label label-{{ $item['status']['color_class'] }}">{{ $item['status']['name'] }}</span>
    <div class="small text-muted m-t-sm">
        {{ $item['receipt_data']['statusReason'] ?? '' }}
    </div>
@endif
