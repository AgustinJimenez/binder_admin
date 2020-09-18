@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('noticias::noticias.title.noticias') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('noticias::noticias.title.noticias') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.noticias.noticia.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('noticias::noticias.button.create noticia') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                    @include("noticias::admin.noticias.partials.index.filtros")
                </div>
                <div class="box-body">
                    @include("noticias::admin.noticias.partials.index.table")
                </div>
            </div>
        </div>
    </div>
    @include("noticias::admin.noticias.partials.modal-confirmation")
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('noticias::noticias.title.create noticia') }}</dd>
    </dl>
@stop

@push('js-stack')
    <?php $locale = locale();  $script_dir_path = "noticias::admin.noticias.partials.index.scripts."; ?>
    @include($script_dir_path . "main")
@endpush
