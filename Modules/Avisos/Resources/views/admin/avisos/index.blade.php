@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('avisos::avisos.title.avisos') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('avisos::avisos.title.avisos') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-3">
                    @include('avisos::admin.avisos.partials.index.create-buttons')
                </div>
                <div class="col-md-9">
                    @include('avisos::admin.avisos.partials.index.table')
                </div>
            </div>
        </div>
    </div>
    @include('avisos::admin.avisos.partials.index.modal-confirmation')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('avisos::avisos.title.create aviso') }}</dd>
    </dl>
@stop

@push('js-stack')
    <?php $script_dir_path = "avisos::admin.avisos.partials.index.scripts."; ?>
    @include($script_dir_path . "main")
@endpush
