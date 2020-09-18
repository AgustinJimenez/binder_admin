@extends('layouts.master')

@section('content-header')
    <h1>
        Responsables
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('responsables::responsables.title.responsables') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.responsables.responsable.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-plus"></i> Agregar
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    @include('responsables::admin.responsables.partials.index.header')
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('responsables::admin.responsables.partials.index.table')
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
    @include('responsables::admin.responsables.partials.index-estado-modal')
    @include('responsables::admin.responsables.partials.confirmation-modal')
    @include('responsables::admin.responsables.partials.generic-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('responsables::responsables.title.create responsable') }}</dd>
    </dl>
@stop

@push('js-stack')
    <?php 
        $script_dir_path = "responsables::admin.responsables.partials.index.scripts."; 
        $locale = locale();
    ?>
    @include($script_dir_path . "main")
@endpush
