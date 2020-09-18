<script type="text/javascript" charset="utf-8">
    $(document).keypressAction({actions: [{ key: 'b', route: "{{ route('admin.noticias.noticia.create') }}" }]});
    $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
    });
	var config = 
	{
		datatable:
		{
			order: [[ 0, "desc" ]],
			ajax_source: '{!! route('admin.noticias.noticia.index_ajax') !!}',
			send_request: function (request) 
            {
                request.colegio_token = "{{ session()->get('colegio_token') }}",
                request.titulo = INPUT_BUSCAR_POR_TITULO.val(),
                request.fecha_inicio = INPUT_FECHA_INICIO.val(),
                request.fecha_fin = INPUT_FECHA_FIN.val()
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
                { data: 'fecha', name: 'fecha', orderable: true, searchable: false},
                { data: 'titulo', name: 'titulo', orderable: true, searchable: false},
                { data: 'acciones', name: 'acciones', orderable: false, searchable: false}
            ],
            default_datas_count: 25,
            tool_bar: '<"toolbar">' + "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                        "<'row'<'col-xs-12't>>"+
                        "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>"




		}//end datatable
	}

</script>