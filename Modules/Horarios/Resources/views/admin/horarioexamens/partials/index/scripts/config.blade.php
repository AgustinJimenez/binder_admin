<script type="text/javascript" charset="utf-8" defer>
    $(document).keypressAction({actions: [{ key: 'c', route: "{{ route('admin.horarios.horarioexamen.create') }}" }]});
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
    });
	var config = 
	{
		datatable:
		{
			order: [[ 0, "desc" ]],
			ajax_source: "{!! route('admin.horarios.horarioexamen.index_ajax') !!}",
			send_request: function ( request ) 
            {
                request.fecha_inicio = INPUT_FECHA_INICIO.val(),
                request.fecha_fin = INPUT_FECHA_FIN.val(),
                request.materia = INPUT_MATERIA.val()
            },
            data_source: function ( response ) 
            {
                return response.data;
            },
            initComplete: function()
            {
                //set_icheckbox();
            },
            columns: 
            [
                { data: 'fecha', name: 'fecha', orderable: true, searchable: false },
                { data: 'materia', name: 'materia', orderable: true, searchable: false },
                { data: 'seccion_grado_nombre', name: 'seccion_grado_nombre', orderable: false, searchable: false },
                { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
            ],
            default_datas_count: 10,
            tool_bar: '<"toolbar">' + "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                        "<'row'<'col-xs-12't>>"+
                        "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>"
		}//end datatable
	}

</script>