<script type="text/javascript" charset="utf-8" defer>
	
	var config = 
	{
		datatable:
		{
			order: [[ 0, "desc" ]],
			ajax_source: '{!! route('admin.avisos.aviso.index_ajax') !!}',
			send_request: function (request) 
            {
                request.colegio_token = '{{ session()->get('colegio_token') }}',
                request.titulo = INPUT_BUSCAR_POR_TITULO.val(),
                request.fecha_desde = INPUT_BUSCAR_FECHA_DESDE.val(),
                request.fecha_hasta = INPUT_BUSCAR_FECHA_HASTA.val(),
                request.categoria_id = SELECT_CATEGORIAS.val(),
                request.grado_id = SELECT_GRADOS.val(),
                request.seccion_id = SELECT_SECCIONES.val()
            },
            data_source: function ( json ) 
            {
                if( !json.data.length )
                {
                    BTN_CONTROL_NEXT.attr('disabled', 'disabled');
                    BTN_CONTROL_PREVIOUS.attr('disabled', 'disabled');
                    BTN_CONTROL_DELETE.attr('disabled', 'disabled');
                    BTN_CONTROL_CHECKBOX_TOGGLE.attr('disabled', 'disabled');
                }
                else
                {
                    BTN_CONTROL_NEXT.removeAttr('disabled');
                    BTN_CONTROL_PREVIOUS.removeAttr('disabled');
                    BTN_CONTROL_DELETE.removeAttr('disabled');
                    BTN_CONTROL_CHECKBOX_TOGGLE.removeAttr('disabled');
                }

                return json.data;
            },
            initComplete: function()
            {
                //set_icheckbox();
            },
            columns: 
            [
                { data: 'checkbox', name: 'checkbox', orderable: true, searchable: false},
                { data: 'created_at', name: 'created_at', orderable: true, searchable: false},
                { data: 'titulo', name: 'titulo', orderable: true, searchable: false},
                { data: 'enviado_recibido', name: 'enviado_recibido', orderable: true, searchable: false},
                { data: 'ver_detalle_btn', name: 'ver_detalle_btn', orderable: true, searchable: false}
            ],
            default_datas_count: 10,
            tool_bar: '<"toolbar">' + "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
                        "<'row'<'col-xs-12't>>"+
                        "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>"




		}//end datatable
	}

</script>