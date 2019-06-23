@extends('admin::back.layouts.app')

@php
    $title = 'Призы';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.checks-contest.prizes::back.partials.breadcrumbs.index')
    @endpush

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <a href="{{ route('back.checks-contest.prizes.create') }}"
                           class="btn btn-sm btn-primary btn-lg">Создать</a>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            {{ $table->table(['class' => 'table table-striped table-bordered table-hover dataTable']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@pushonce('scripts:datatables_checks_prizes_index')
{!! $table->scripts() !!}
@endpushonce
