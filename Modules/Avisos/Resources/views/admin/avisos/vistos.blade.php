@extends('layouts.master')

@section('content-header')

    <div class="row">

        <div class="col-md-4">
            <h1> {{ $aviso->titulo }} </h1>
        </div>

        <div class="col-md-4">
            <h1> {{ $aviso->created_at }} </h1>
        </div>

    </div>
    
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-md-12">
                    @include('avisos::admin.avisos.partials.vistos.table')
                </div>
            </div>
        </div>
    </div>
    @include('avisos::admin.avisos.partials.vistos.modal')
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
    <?php $script_dir_path = "avisos::admin.avisos.partials.vistos.scripts."; ?>
    @include($script_dir_path . "main")
@endpush
