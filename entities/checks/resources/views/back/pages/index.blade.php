@extends('admin::back.layouts.app')

@php
    $title = 'Чеки';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.checks-contest.checks::back.partials.breadcrumbs.index')
    @endpush

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <a href="{{ route('back.checks-contest.checks.export') }}" class="btn btn-xs btn-primary">Экспорт</a>
                        </div>
                    </div>
                    <div class="checks-content ibox-content">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>
                        <div class="table-responsive">
                            {{ $table->table(['class' => 'check-table table table-striped table-bordered table-hover dataTable']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.module.fns.receipts::back.modals.receipts')
@endsection

@pushonce('scripts:datatables_checks_checks_index')
{!! $table->scripts() !!}
@endpushonce
