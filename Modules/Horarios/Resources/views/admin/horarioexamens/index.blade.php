@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('horarios::horarioexamens.title.horarioexamens') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('horarios::horarioexamens.title.horarioexamens') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.horarios.horarioexamen.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('horarios::horarioexamens.button.create horarioexamen') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    @include('horarios::admin.horarioexamens.partials.index.header')
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        @include('horarios::admin.horarioexamens.partials.index.table')
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('horarios::horarioexamens.title.create horarioexamen') }}</dd>
    </dl>
@stop

@push('js-stack')
    <?php $locale = locale();  $script_dir_path = "horarios::admin.horarioexamens.partials.index.scripts."; ?>
    @include($script_dir_path . "main")
@endpush
