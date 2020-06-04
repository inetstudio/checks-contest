@php
    /** @var InetStudio\ReceiptsContest\Statuses\Contracts\Models\StatusModelContract $item */

    $title = ($item['id']) ? 'Просмотр статуса' : 'Создание статуса';
@endphp

@extends('admin::back.layouts.app')

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.receipts-contest.statuses::back.partials.breadcrumbs.form')
    @endpush

    <div class="wrapper wrapper-content">
        <div class="ibox">
            <div class="ibox-title">
                <a class="btn btn-sm btn-white" href="{{ route('back.receipts-contest.statuses.index') }}">
                    <i class="fa fa-arrow-left"></i> Вернуться назад
                </a>
            </div>
        </div>

        {!! Form::info() !!}

        {!! Form::open(['url' => (! $item['id']) ? route('back.receipts-contest.statuses.store') : route('back.receipts-contest.statuses.update', [$item['id']]), 'id' => 'mainForm']) !!}

            @if ($item['id'])
                {{ method_field('PUT') }}
            @endif

            {!! Form::hidden('id', $item['id'] ?? 0, ['id' => 'object-id']) !!}

            {!! Form::hidden('type', get_class($item), ['id' => 'object-type']) !!}

            <div class="ibox">
                <div class="ibox-title">
                    {!! Form::buttons('', '', ['back' => 'back.receipts-contest.statuses.index']) !!}
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

                                            {!! Form::string('name', $item['name'], [
                                                'label' => [
                                                    'title' => 'Название',
                                                ],
                                            ]) !!}

                                            {!! Form::string('alias', $item['alias'], [
                                                'label' => [
                                                    'title' => 'Алиас',
                                                ],
                                            ]) !!}

                                            {!! Form::wysiwyg('description', $item['description'], [
                                                'label' => [
                                                    'title' => 'Описание',
                                                ],
                                                'field' => [
                                                    'class' => 'tinymce-simple',
                                                    'type' => 'simple',
                                                    'id' => 'description',
                                                ],
                                            ]) !!}

                                            {!! Form::classifiers('', $item, [
                                                'label' => [
                                                    'title' => 'Свойства статуса',
                                                ],
                                                'field' => [
                                                    'placeholder' => 'Выберите свойства статуса',
                                                    'group' => 'receipts_contest_status_type',
                                                ],
                                            ]) !!}

                                            {!! Form::dropdown('color_class', $item['color_class'] ?? 'default', [
                                                'label' => [
                                                    'title' => 'Цветовое обозначение',
                                                ],
                                                'field' => [
                                                    'class' => 'select2-drop form-control',
                                                    'data-placeholder' => 'Выберите цвет',
                                                    'style' => 'width: 100%',
                                                ],
                                                'options' => [
                                                    'values' => [
                                                        null => '',
                                                        'default' => 'default',
                                                        'primary' => 'primary',
                                                        'success' => 'success',
                                                        'info' => 'info',
                                                        'warning' => 'warning',
                                                        'danger' => 'danger',
                                                    ],
                                                ],
                                            ]) !!}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-footer">
                    {!! Form::buttons('', '', ['back' => 'back.receipts-contest.statuses.index']) !!}
                </div>
            </div>

        {!! Form::close()!!}
    </div>
@endsection
