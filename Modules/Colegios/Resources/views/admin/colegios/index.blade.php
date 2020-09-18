@extends('layouts.master')

@section('content-header')
    <h1>
        Colegios
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('colegios::colegios.title.colegios') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.colegios.colegio.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-plus"></i> Agregar
                    </a>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Imagen</th>
                                    <th class="text-center">Tiene varias secciones</th>
                                    <th class="text-center" data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (isset($colegios)): ?>
                            <?php foreach ($colegios as $colegio): ?>
                            <tr>
                                <td class="text-center">
                                    <a href="{{ route('admin.colegios.colegio.edit', [$colegio->id]) }}">
                                        {{ $colegio->nombre }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    @if( $colegio->imagen )
                                        <img src="{{ Imagy::getThumbnail($colegio->imagen->path, 'smallThumb') }}" alt="" />
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.colegios.colegio.edit', [$colegio->id]) }}">
                                        @if($colegio->tiene_varias_secciones)
                                            Si
                                        @else
                                            No
                                        @endif
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.colegios.colegio.edit', [$colegio->id]) }}" class="btn btn-default btn-flat"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.colegios.colegio.destroy', [$colegio->id]) }}"><i class="fa fa-trash"></i></button>
                                        @if($currentUser->hasRoleName('Admin') and ( \Helper::getSessionColegio() ? \Helper::getSessionColegio()->id : null ) != $colegio->id )
                                            <a class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-colegio" data-action-target="{{ route('admin.colegios.colegio.set-colegio', [$colegio->id]) }}">
                                                Establecer Colegio 
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot class="bg-primary">
                                <tr>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Imagen</th>
                                    <th class="text-center">Tiene varias secciones</th>
                                    <th class="text-center">{{ trans('core::core.table.actions') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
    @if($currentUser->hasRoleName('Admin'))
        @include('colegios::admin.colegios.partials.modal-colegio')
    @endif
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('colegios::colegios.title.create colegio') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() 
        {
            $(document).keypressAction({actions: [{ key: 'c', route: "<?= route('admin.colegios.colegio.create') ?>" }]});
        });
    </script>
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "asc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                }
            });
        });
    </script>
@endpush
