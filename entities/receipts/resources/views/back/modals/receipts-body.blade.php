{!! Form::open(['url' => route('back.receipts-contest.receipts.update', [$item['id']]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data']) !!}
    @if ($item['id'])
        {{ method_field('PUT') }}
    @endif

    {!! Form::hidden('receipt_id', (! $item['id']) ? '' : $item['id'], ['id' => 'object-id']) !!}

    <div class="row m-b-md">
        <div class="col-lg-12">
            <span class="btn btn-sm btn-{{ $item['status']['color_class'] }} float-right">{{ $item['status']['name'] }}</span>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox border-bottom collapsed">
                <div class="ibox-title">
                    <h5>Данные с формы</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="display: none;">
                    <pre class="json-data">@json($item['additional_info'])</pre>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox border-bottom collapsed">
                <div class="ibox-title">
                    <h5>Данные чека</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="display: none;">
                    <pre class="json-data">@json($item['receipt_data'])</pre>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Чек</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-10">
                            @if (! empty($item['fnsReceipt']))
                                <div class="m-b-lg">
                                    @if (isset($item['fnsReceipt']['receipt']['document']['receipt']['user']))
                                        <p><strong>Юридическое лицо: </strong>{{ $item['fnsReceipt']['receipt']['document']['receipt']['user'] }}</p>
                                    @endif

                                    @if (isset($item['fnsReceipt']['receipt']['document']['receipt']['userInn']))
                                        <p><strong>ИНН: </strong>{{ $item['fnsReceipt']['receipt']['document']['receipt']['userInn'] }}</p>
                                    @endif

                                    @if (isset($item['fnsReceipt']['receipt']['document']['receipt']['retailPlace']))
                                        <p><strong>Место покупки: </strong>{{ $item['fnsReceipt']['receipt']['document']['receipt']['retailPlace'] }}</p>
                                    @endif

                                    @if (isset($item['fnsReceipt']['receipt']['document']['receipt']['retailPlaceAddress']))
                                        <p><strong>Адрес: </strong>{{ $item['fnsReceipt']['receipt']['document']['receipt']['retailPlaceAddress'] }}</p>
                                    @endif
                                </div>

                                @if (isset($item['fnsReceipt']['receipt']['document']['receipt']['dateTime']))
                                    @php
                                        $receiptDate = \Illuminate\Support\Carbon::parse($item['fnsReceipt']['receipt']['document']['receipt']['dateTime']);
                                    @endphp
                                    <div class="m-b-lg">
                                        <p><strong>Дата покупки: </strong>{{ $receiptDate->format('d.m.Y') }}</p>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="col-lg-2">
                            @if ($item['preview']['id'])
                                <a data-fancybox="" href="{{ $item['preview']['src'] }}">
                                    <img src="{{ $item['preview']['thumb'] }}" class="m-b-md img-responsive" alt="check">
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="m-b-lg">
                        @include('admin.module.receipts-contest.receipts::back.modals.additional_fields')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Товары</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div>
                        <products-list
                            v-bind:products-prop="{{ json_encode($item['products']) }}"
                            v-bind:fns-receipt-id-prop="{{ $item['fns_receipt_id'] }}"
                            v-bind:receipt-id-prop="{{ $item['id'] }}"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox border-bottom collapsed">
                <div class="ibox-title">
                    <h5>Призы</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content" style="display: none;">
                    <div>
                        <receipts-contest-prizes-list
                            v-bind:prizes-prop="{{ json_encode($item['prizes']) }}"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

{!! Form::close()!!}
