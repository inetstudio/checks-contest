@if ($item->getFirstMediaUrl('images'))
    <a data-fancybox="receipts_contest_receipts" href="{{ url($item->getFirstMediaUrl('images')) }}">
        <img src="{{ url($item->getFirstMediaUrl('images', 'admin_index_thumb')) }}" class=" m-b-md img-responsive" alt="receipt">
    </a>
@endif
