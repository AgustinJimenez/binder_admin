<div id="secondary-box" class="box box-primary" style="display: none;">
    <div class="box-header">
        {!! Form::open(['route' => 'admin.responsables.responsable.index-ajax', 'method' => 'post', 'id' => 'search-form']) !!}
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
            <div class="col-sm-2">
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    <div class="inner-addon right-addon">
                        <i class="glyphicon glyphicon-trash" title="Borrar filtro"></i>
                        {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table id="ajax-table" class="data-table table table-bordered table-hover" style="width: 100%;">
                <thead>
                    <tr>
                        <th>C.I.</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
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
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>C.I.</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th data-sortable="false">{{ trans('core::core.table.actions') }}</th>
                    </tr>
                </tfoot>
            </table>
            <!-- /.box-body -->
        </div>
    </div>
    <!-- /.box -->
</div>

{!! Form::open(['route' => ['admin.alumnos.alumno.add-responsable'], 'method' => 'post', 'class' => 'pull-left', 'id' => 'add-form']) !!}
    {!! Form::hidden('alumno_id', $alumno->id) !!}
    {!! Form::hidden('responsable_id', null) !!}
{!! Form::close() !!}

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function()
        {
            var $search_form = $('#search-form');
            var $add_form = $('#add-form');
            var $ajax_table = $('#ajax-table');

            $search_form.find('input').on('keyup keypress blur change', function()
            {
                $search_form.submit();
            });

            $('.glyphicon.glyphicon-trash').click(function()
            {
                $(this).parent().find('input').val('');
                $search_form.submit();
            });

            $search_form.on('submit', function(e)
            {
                table.draw();
                e.preventDefault();
            });

            $ajax_table.on('click', '.add-btn', function(e)
            {
                e.preventDefault();
                var id = $(this).data('id');
                $.confirm({
                    title: 'Atención!',
                    content: 'Está seguro que desea agregar al responsable?',
                    backgroundDismiss: true,
                    buttons: {
                        aceptar: {
                            text: 'Aceptar',
                            btnClass: 'btn-blue',
                            action: function()
                            {
                                $('input[name=responsable_id]').val(id);    
                                $add_form.submit();
                            }
                        },
                        cancelar : {
                            text: 'Cancelar',
                            btnClass: 'btn-default',
                            action: function() {}
                        }
                    }
                });
            });

            var table = $ajax_table.DataTable(
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
                        url: '{!! route('admin.responsables.responsable.index-ajax', ['add_index' => true, 'alumno_id' => $alumno->id]) !!}',
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        data: function (e)
                        {
                            e.nombre = $('#nombre').val();
                            e.apellido = $('#apellido').val();
                            e.ci = $('#ci').val();
                            e.email = $('#email').val();
                        }
                    },
                columns:
                    [
                        { data: 'ci' , name: 'ci' },
                        { data: 'nombre', name: 'nombre' },
                        { data: 'apellido', name: 'apellido' },
                        { data: 'email' , name: 'email' },
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
        });
    </script>
@endpush
