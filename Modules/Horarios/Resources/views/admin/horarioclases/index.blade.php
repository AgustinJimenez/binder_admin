@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('horarios::horarioclases.title.horarioclases') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('horarios::horarioclases.title.horarioclases') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.horarios.horarioclase.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('horarios::horarioclases.button.create horarioclase') }}
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                
                <div class="box-body">
                    <div class="table-responsive">
                        @include("horarios::admin.horarioclases.partials.index.table")
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
        <dd>{{ trans('horarios::horarioclases.title.create horarioclase') }}</dd>
    </dl>
@stop

@push('js-stack')
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $( document ).ready(function() 
        {
            $(document).keypressAction({actions: [{ key: 'c', route: "<?= route('admin.horarios.horarioclase.create') ?>" }]});
        });
        $(function () 
        {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@endpush
