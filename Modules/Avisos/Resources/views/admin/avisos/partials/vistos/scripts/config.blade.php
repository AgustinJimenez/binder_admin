<script type="text/javascript" charset="utf-8" defer>
	$.fn.dataTable.ext.errMode = 'none';
	var config = 
	{
		datatable:
		{
			order: [[ 0, "desc" ]],
			ajax_source: '{!! route('admin.avisos.aviso.vistos_index_ajax') !!}',
			send_request: function (request) 
            {
                request.aviso_id = '{{ $aviso->id }}',
                request.colegio_token = '{{ session()->get('colegio_token') }}',
                request.nombre_apellido = INPUT_BUSCAR_POR_NOMBRE_APELLIDO.val(),
                request.leido = SELECT_VISTO.val(),
                request.categoria_id = SELECT_CATEGORIAS.val(),
                request.grado_id = SELECT_GRADOS.val(),
                request.seccion_id = SELECT_SECCIONES.val(),
                request.estado = SELECT_ESTADO.val()
            },
            data_source: function ( json ) 
            {
                return json.data;
            },
            initComplete: function()
            {
                //set_icheckbox();
            },
            columns: 
            [
                { data: 'rownum', name: 'rownum', orderable: true, searchable: false},
                { data: 'nombre', name: 'nombre', orderable: true, searchable: false},
                { data: 'apellido', name: 'apellido', orderable: true, searchable: false},
                { data: 'tipo_encargado', name: 'tipo_encargado', orderable: true, searchable: false},
                { data: 'telefono', name: 'telefono', orderable: true, searchable: false},
                { data: 'user.email', name: 'user.email', orderable: true, searchable: false},
                { data: 'estado', name: 'estado', orderable: true, searchable: false},
                { data: 'visto', name: 'visto', orderable: true, searchable: false}
            ],
            default_datas_count: 10,
            tool_bar: '<"toolbar">' + "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                        "<'row'<'col-xs-12't>>"+
                        "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>"




		}//end datatable
	}

</script>