@extends('layouts.master')

@section('content-header')
    <h1>
        {{$responsable->nombre . ' ' . $responsable->apellido}} - Alumnos
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">Responsable - Alumnos</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a id="toggle-table" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-plus"></i> Agregar Alumno
                    </a>
                    <a id="go-back" class="btn btn-primary btn-flat" style="padding: 4px 10px; display: none;">
                        <i class="fa fa-arrow-left"></i> Aceptar
                    </a>
                </div>
            </div>
            <div id="primary-box" class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="data-table table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>C.I.</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Grado</th>
                                    <th>Sección</th>
                                    <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($relaciones))
                                @foreach($relaciones as $relacion)
                                    <tr>
                                        <td>
                                            <a href="#">
                                                {{ empty($relacion->alumno->ci) ? 'N/A' : $relacion->alumno->ci }}
                                            </a>
                                        </td>
                                        <td>
                                            {!! $relacion->alumno->withHref($relacion->alumno->nombre)  !!}
                                        </td>
                                        <td>
                                            {!! $relacion->alumno->withHref($relacion->alumno->apellido)  !!}
                                        </td>
                                        <td>
                                            {!! $relacion->alumno->grado->withHref($relacion->alumno->grado->nombre)  !!}
                                        </td>
                                        <td>
                                            <a href="{{ ($relacion->alumno->seccion) ? route('admin.grados.seccion.edit', [$relacion->alumno->seccion->id]) : '#'  }}">
                                                {{ empty($relacion->alumno->seccion) ? 'N/A' : $relacion->alumno->seccion->nombre }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.responsables.responsable.remove-alumno', [$relacion->id]) }}"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>C.I.</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Grado</th>
                                    <th>Sección</th>
                                    <th>{{ trans('core::core.table.actions') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
            @include('responsables::admin.responsables.partials.ajax-alumnos', ['responsable' => $responsable])
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
        <dd>Responsable - Alumnos</dd>
    </dl>
@stop

@push('js-stack')
    <?php $locale = locale(); ?>
    <script type="text/javascript">
        $(function ()
        {
            var $primary_box = $('#primary-box');
            var $secondary_box = $('#secondary-box');
            var $toggle_table = $('#toggle-table');
            var $go_back = $('#go-back');

            $toggle_table.click(function(event)
            {
                handleView();
            });

            $go_back.click(function(event)
            {
                handleView();
            });

            function handleView()
            {
                $primary_box.toggle('slow');
                $secondary_box.toggle('slow');
                $toggle_table.toggle('slow');
                $go_back.toggle('slow');
            }

            $('#primary-table').dataTable(
            {
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "asc" ]],
                "language": {
                    "url": '{{ Module::asset("core:js/vendor/datatables/{$locale}.json") }}'
                }
            });
        });
    </script>
@endpush
