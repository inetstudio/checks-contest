{!! Form::open(['url' => (! $item['id']) ? route('back.checks-contest.checks.store') : route('back.checks-contest.checks.update', [$item['id']]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data']) !!}
@if ($item['id'])
    {{ method_field('PUT') }}
@endif

<div class="m-b-lg">
    @if ($item->hasJSONData('receipt_data', 'receipt.user'))
        <p><strong>Юридическое лицо: </strong>{{ $item->getJSONData('receipt_data', 'receipt.user', '') }}</p>
    @endif

    @if ($item->hasJSONData('receipt_data', 'receipt.userInn'))
        <p><strong>ИНН: </strong>{{ $item->getJSONData('receipt_data', 'receipt.userInn', '') }}</p>
    @endif

    @if ($item->hasJSONData('receipt_data', 'receipt.retailPlace'))
        <p><strong>Место покупки: </strong>{{ $item->getJSONData('receipt_data', 'receipt.retailPlace', '') }}</p>
    @endif

    @if ($item->hasJSONData('receipt_data', 'receipt.retailPlaceAddress'))
        <p><strong>Адрес: </strong>{{ $item->getJSONData('receipt_data', 'receipt.retailPlaceAddress', '') }}</p>
    @endif
</div>

@if ($item->hasJSONData('receipt_data', 'receipt.dateTime'))
    @php
        $receiptDate = \Illuminate\Support\Carbon::parse($item->getJSONData('receipt_data', 'receipt.dateTime'));
    @endphp
    <div class="m-b-lg">
        <p><strong>Дата покупки: </strong>{{ $receiptDate->format('d.m.Y') }}</p>
    </div>
@endif

<div>
    <products-list
            v-bind:products-prop="{{ json_encode($item->products->toArray()) }}"
            v-bind:fns-receipt-id-prop="{{ $item['fns_receipt_id'] }}"
            v-bind:receipt-id-prop="{{ $item['id'] }}"
    />
</div>
{!! Form::close()!!}
