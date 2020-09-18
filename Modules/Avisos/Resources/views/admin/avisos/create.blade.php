@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('avisos::avisos.title.create aviso') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.avisos.aviso.index') }}">{{ trans('avisos::avisos.title.avisos') }}</a></li>
        <li class="active">{{ trans('avisos::avisos.title.create aviso') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.avisos.aviso.store'], 'method' => 'post']) !!}
    <div class="row">
        @if( $tipo != 'general' )
            <div class="col-md-4">
                @include('avisos::admin.avisos.partials.fields-tipos')
            </div>
        @endif
        <div class="col-md-{{ ($tipo == 'general')?12:8 }}">
            @include('avisos::admin.avisos.partials.fields') 
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
<?php $script_dir_path = "avisos::admin.avisos.partials.create.scripts."; ?>
    @include($script_dir_path . "main")
@endpush
