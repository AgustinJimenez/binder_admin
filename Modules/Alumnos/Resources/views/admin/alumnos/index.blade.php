@extends('layouts.master')

@section('content-header')
    <h1>
        Alumnos
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('alumnos::alumnos.title.alumnos') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <a href="{{ route('admin.alumnos.alumno.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-plus"></i> Agregar
                    </a>
                </div>
            </div>
            <div class="box box-primary">

                <div class="box-header">
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::label('ci', 'C.I.') !!}
                                <div class="inner-addon right-addon">
                                    <i class="glyphicon glyphicon-trash" title="Borrar filtro"></i>
                                    {!! Form::text('ci', null, ['class' => 'form-control', 'id' => 'ci']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::label('nombre', 'Nombre') !!}
                                <div class="inner-addon right-addon">
                                    <i class="glyphicon glyphicon-trash" title="Borrar filtro"></i>
                                    {!! Form::text('nombre', null, ['class' => 'form-control', 'id' => 'nombre']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::label('apellido', 'Apellido') !!}
                                <div class="inner-addon right-addon">
                                    <i class="glyphicon glyphicon-trash" title="Borrar filtro"></i>
                                    {!! Form::text('apellido', null, ['class' => 'form-control', 'id' => 'apellido']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            {!! Form::normalSelect('grado_id', 'Grado', $errors, \Helper::addDefaultOptionArray($grados)) !!}
                        </div>
                        <div class="col-sm-3" style="display: {{ \Helper::colegioTieneVariasSecciones() ? 'block' : 'none' }}">
                            {!! Form::normalSelect('seccion_id', 'Sección', $errors, \Helper::addDefaultOptionArray(), null, ['disabled' => 'disabled']) !!}
                        </div>
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
                                    <th>Fecha de Nacimiento</th>
                                    <th>Grado</th>
                                    <th>Sección</th>
                                    <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>C.I.</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Fecha de Nacimiento</th>
                                    <th>Grado</th>
                                    <th>Sección</th>
                                    <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
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
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('alumnos::alumnos.title.create alumno') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function()
        {
            var $form = $('#search-form');
            var $grado = $('#grado_id');
            var $seccion = $('#seccion_id');
            var route = "{{ route('admin.alumnos.alumno.remote-select') }}";
            var table = $('.data-table').DataTable(
            {
                dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                "<'row'<'col-xs-12't>>"+
                "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
                "deferRender": true,
                processing: false,
                serverSide: true,
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                ajax:
                    {
                        url: '{!! route('admin.alumnos.alumno.index-ajax') !!}',
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        data: function (e)
                        {
                            e.nombre = $('#nombre').val();
                            e.apellido = $('#apellido').val();
                            e.ci = $('#ci').val();
                            e.grado_id = $grado.val();
                            e.seccion_id = $seccion.val();
                        }
                    },
                columns:
                    [
                        { data: 'ci' , name: 'ci' },
                        { data: 'nombre', name: 'nombre' },
                        { data: 'apellido', name: 'apellido' },
                        { data: 'fecha_nacimiento' , name: 'fecha_nacimiento' },
                        { data: 'grado' , name: 'grado' },
                        { data: 'seccion' , name: 'seccion' },
                        { data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                language: {
                    processing:     "Procesando...",
                    search:         "Buscar",
                    lengthMenu:     "Mostrar _MENU_ Elementos",
                    info:           "Mostrando de _START_ al _END_ registros de un total de _TOTAL_ registros",
                    infoFiltered:   ".",
                    infoPostFix:    "",
                    loadingRecords: "Cargando Registros...",
                    zeroRecords:    "No existen registros disponibles",
                    emptyTable:     "No existen registros disponibles",
                    paginate: {
                        first:      "Primera",
                        previous:   "Anterior",
                        next:       "Siguiente",
                        last:       "Ultima"
                    }
                }
            });

            $(".box-header input").on("keyup", function()
            {
                table.draw();
            });
            $grado.on('change', function()
            {
                table.draw();
            });

            $seccion.on('change', function()
            {
                table.draw();
            });

            $('.glyphicon.glyphicon-trash').click(function()
            {
                $(this).parent().find('input').val('');
                table.draw();
            });

            $form.on('submit', function(e)
            {
                table.draw();
                e.preventDefault();
            });

            $seccion.remoteChained(
            {
                parents : "#grado_id",
                url : route
            });

            

            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "{{ route('admin.alumnos.alumno.create') }}" }
                ]
            });
        });
    </script>
    <?php $locale = locale(); ?>
@endpush
