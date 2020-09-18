@extends('layouts.master')

@section('content-header')
    <h1>
        {{$alumno->nombre . ' ' . $alumno->apellido}} - Responsables
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">Alumno - Responsables</li>
    </ol>
@stop

@section('styles')
    <style type="text/css">
        #modal-add-responsable .modal-dialog {
            width: 900px;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a id="toggle-table" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-plus"></i> Agregar Responsable
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
                        <table id="primary-table" class="data-table table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>C.I.</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Teléfono</th>
                                    <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($relaciones))
                                @foreach($relaciones as $relacion)
                                    <tr>
                                        <td>
                                            <a href="#">
                                                {{ empty($relacion->responsable->ci) ? 'N/A' : $relacion->responsable->ci }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#">
                                                {{ $relacion->responsable->nombre }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#">
                                                {{ $relacion->responsable->apellido }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#">
                                                @if($relacion->responsable->telefono)
                                                    {{ $relacion->responsable->telefono }}
                                                @else
                                                    N/A
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ route('admin.alumnos.alumno.remove-responsable', [$relacion->id]) }}"><i class="fa fa-trash"></i></button>
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
                                    <th>Teléfono</th>
                                    <th>{{ trans('core::core.table.actions') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.box -->
            </div>
            @include('alumnos::admin.alumnos.partials.ajax-responsables', ['alumno' => $alumno])
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
        <dd>Alumno - Responsables</dd>
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
