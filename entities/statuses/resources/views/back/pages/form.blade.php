@extends('admin::back.layouts.app')

@php
    $title = ($item['id']) ? 'Просмотр статуса' : 'Создание статуса';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.checks-contest.statuses::back.partials.breadcrumbs.form')
    @endpush

    <div class="wrapper wrapper-content">
        <div class="ibox">
            <div class="ibox-title">
                <a class="btn btn-sm btn-white" href="{{ route('back.checks-contest.statuses.index') }}">
                    <i class="fa fa-arrow-left"></i> Вернуться назад
                </a>
            </div>
        </div>

        {!! Form::info() !!}

        {!! Form::open(['url' => (! $item->id) ? route('back.checks-contest.statuses.store') : route('back.checks-contest.statuses.update', [$item->id]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data']) !!}

        @if ($item->id)
            {{ method_field('PUT') }}
        @endif

        {!! Form::hidden('status_id', (! $item->id) ? '' : $item->id, ['id' => 'object-id']) !!}

        {!! Form::hidden('status_type', get_class($item), ['id' => 'object-type']) !!}

        <div class="ibox">
            <div class="ibox-title">
                {!! Form::buttons('', '', ['back' => 'back.checks-contest.statuses.index']) !!}
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

                                        {!! Form::string('name', $item->name, [
                                            'label' => [
                                                'title' => 'Название',
                                            ],
                                        ]) !!}

                                        {!! Form::string('alias', $item->alias, [
                                            'label' => [
                                                'title' => 'Алиас',
                                            ],
                                        ]) !!}

                                        {!! Form::wysiwyg('description', $item->description, [
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
                                                'title' => 'Тип статуса',
                                            ],
                                            'field' => [
                                                'placeholder' => 'Выберите типы статуса',
                                                'group' => 'checks_contest_status_type',
                                            ],
                                        ]) !!}

                                        {!! Form::dropdown('color_class', (! $item->id) ? 'default' : $item->color_class, [
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

                                        {!! Form::hidden('fill_reason', 0) !!}
                                        {!! Form::checks('fill_reason', $item->fill_reason, [
                                            'label' => [
                                                'title' => 'Указать причину перевода',
                                            ],
                                            'checks' => [
                                                [
                                                    'value' => 1,
                                                ],
                                            ],
                                        ]) !!}

                                        {!! Form::hidden('draw', 0) !!}
                                        {!! Form::checks('draw', $item->draw, [
                                            'label' => [
                                                'title' => 'Участвует в розыгрыше призов',
                                            ],
                                            'checks' => [
                                                [
                                                    'value' => 1,
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
                {!! Form::buttons('', '', ['back' => 'back.checks-contest.statuses.index']) !!}
            </div>
        </div>

        {!! Form::close()!!}
    </div>
@endsection
