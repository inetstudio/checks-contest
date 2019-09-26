{!! Form::open(['url' => (! $item['id']) ? route('back.checks-contest.checks.store') : route('back.checks-contest.checks.update', [$item['id']]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data']) !!}
@if ($item['id'])
    {{ method_field('PUT') }}
@endif

<div class="m-b-lg">
    @if ($item->hasJSONData('receipt_data', 'user'))
        <p><strong>Юридическое лицо: </strong>{{ $item->getJSONData('receipt_data', 'user', '') }}</p>
    @endif

    @if ($item->hasJSONData('receipt_data', 'userInn'))
        <p><strong>ИНН: </strong>{{ $item->getJSONData('receipt_data', 'userInn', '') }}</p>
    @endif

    @if ($item->hasJSONData('receipt_data', 'retailPlace'))
        <p><strong>Место покупки: </strong>{{ $item->getJSONData('receipt_data', 'retailPlace', '') }}</p>
    @endif

    @if ($item->hasJSONData('receipt_data', 'retailPlaceAddress'))
        <p><strong>Адрес: </strong>{{ $item->getJSONData('receipt_data', 'retailPlaceAddress', '') }}</p>
    @endif
</div>

@if ($item->hasJSONData('receipt_data', 'dateTime'))
    @php
        $receiptDate = \Illuminate\Support\Carbon::parse($item->getJSONData('receipt_data', 'dateTime'));
    @endphp
    <div class="m-b-lg">
        <p><strong>Дата покупки: </strong>{{ $receiptDate->format('d.m.Y') }}</p>
    </div>
@endif

<div class="table-responsive">
    <table class="table table-hover">
        <tbody>
        <tr>
            <th>Продукт</th>
            <th>Количество</th>
            <th>Цена</th>
            <th>Сумма</th>
        </tr>
        @foreach ($item['products'] as $productItem)
            <tr>
                <td>{{ $productItem['name'] }}</td>
                <td>{{ $productItem['quantity'] }}</td>
                <td>{{ $productItem['price_formatted'] }}</td>
                <td>{{ $productItem['sum'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td><strong>Итого:</strong></td>
            <td><strong>{{ $item['products']->sum('sum') }}</strong></td>
        </tr>
        </tbody>
    </table>
</div>
<hr>
{!! Form::close()!!}
