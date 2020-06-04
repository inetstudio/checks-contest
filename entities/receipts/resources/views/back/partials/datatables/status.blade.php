@if ($item['status'])
    <span class="label label-{{ $item['status']['color_class'] }}">{{ $item['status']['name'] }}</span>
@endif
