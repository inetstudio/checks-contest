@php
    /** @var Yajra\DataTables\Html\Builder $table */

    $title = 'Чеки';
@endphp

@extends('admin::back.layouts.app')

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.receipts-contest.receipts::back.partials.breadcrumbs.index')
    @endpush

    <div class="wrapper wrapper-content">
        <div class="row" id="receipts_contest_receipts">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <a href="{{ route('back.receipts-contest.receipts.export.default') }}" class="btn btn-xs btn-primary">Экспорт</a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>
                        <div class="table-responsive">
                            {{ $table->table(['class' => 'receipts-contest-receipts-table table table-striped table-bordered table-hover dataTable']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@pushonce('scripts:datatables_receipts_contest_receipts_index')
    {!! $table->scripts() !!}
@endpushonce
