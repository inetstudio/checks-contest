@extends('admin::back.layouts.app')

@php
    $title = ($item['id']) ? 'Редактирование чека' : 'Создание чека';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.checks-contest.checks::back.partials.breadcrumbs.form')
    @endpush

    <div class="wrapper wrapper-content" id="checkForm">
        <div class="ibox">
            <div class="ibox-title">
                <a class="btn btn-sm btn-white" href="{{ route('back.checks-contest.checks.index') }}">
                    <i class="fa fa-arrow-left"></i> Вернуться назад
                </a>
            </div>
        </div>

        {!! Form::info() !!}

        {!! Form::open(['url' => (! $item['id']) ? route('back.checks-contest.checks.store') : route('back.checks-contest.checks.update', [$item['id']]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data']) !!}

        @if ($item['id'])
            {{ method_field('PUT') }}
        @endif

        {!! Form::hidden('check_id', (! $item['id']) ? '' : $item['id'], ['id' => 'object-id']) !!}

        {!! Form::hidden('check_type', get_class($item), ['id' => 'object-type']) !!}

        <div class="ibox">
            <div class="ibox-title">
                {!! Form::buttons('', '', ['back' => 'back.checks-contest.checks.index']) !!}
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel-group float-e-margins" id="mainAccordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMain"
                                           aria-expanded="true">Основная информация</a>
                                    </h5>
                                </div>
                                <div id="collapseMain" class="collapse show" aria-expanded="true">
                                    <div class="panel-body">

                                        <div class="form-group row">
                                            <label for="message" class="col-sm-2 col-form-label font-bold">Данные с формы</label>

                                            <div class="col-sm-10">
                                                <pre class="json-data">@json($item['additional_info'])</pre>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        @if ($item->getFirstMedia('images'))
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label font-bold">Чек</label>
                                                <div class="col-sm-1">
                                                    @if (count($item['fnsReceipts']) > 0)
                                                        <button class="btn btn-default show-receipts" type="button" data-url="{{ route('back.checks-contest.checks.show', [$item['id']]) }}">
                                                            <i class="fa fa-qrcode"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                                <div class="col-sm-9">
                                                    <a data-fancybox="" href="{{ url($item->getFirstMediaUrl('images')) }}">
                                                        <img src="{{ url($item->getFirstMedia('images')->getUrl('admin_index_thumb')) }}"
                                                             class="m-b-md img-responsive" alt="check">
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapsePrizes"
                                           aria-expanded="true">Информация о призах</a>
                                    </h5>
                                </div>
                                <div id="collapsePrizes" class="collapse" aria-expanded="true">
                                    <div class="panel-body">

                                        <div>
                                            <prizes-list
                                                v-bind:prizes-prop="{{ json_encode($item->prizes->toArray()) }}"
                                            />
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-footer">
                {!! Form::buttons('', '', ['back' => 'back.checks-contest.checks.index']) !!}
            </div>
        </div>

        {!! Form::close()!!}
    </div>

    @include('admin.module.checks-contest.checks::back.modals.receipts')
@endsection
