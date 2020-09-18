<script type="text/javascript" charset="utf-8">
	
	var config = 
	{
		datatable:
		{
			order: [[ 0, "desc" ]],
			ajax_source: '{!! route('admin.responsables.responsable.index-ajax') !!}',
			send_request: function (request) 
            {
                request.colegio_token = '{{ session()->get('colegio_token') }}',
                request.categoria_id = SELECT_CATEGORIAS.val(),
                request.grado_id = SELECT_GRADOS.val(),
                request.seccion_id = SELECT_SECCIONES.val(), 
                request.estado = SELECT_ESTADO.val(),
                request.nombre = INPUT_NOMBRE.val(),
                request.apellido = INPUT_APELLIDO.val(),
                request.email = INPUT_EMAIL.val()
            },
            data_source: function ( json ) 
            {
                console.log( json.data.debug_message );
                return json.data;
            },
            initComplete: function()
            {
                //set_icheckbox();
            },
            columns: 
            [
                { data: 'nombre', name: 'nombre' },
                { data: 'apellido', name: 'apellido' },
                { data: 'email' , name: 'email' },
                { data: 'tipo_encargado' , name: 'tipo_encargado' },
                { data: 'estado' , name: 'estado' },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            default_datas_count: 10,
            tool_bar: '<"toolbar">' + "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                        "<'row'<'col-xs-12't>>"+
                        "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>"




		}//end datatable
	}

</script>