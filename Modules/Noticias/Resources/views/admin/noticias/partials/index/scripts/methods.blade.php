<script type="text/javascript" charset="utf-8">

    var tmp_ajax_action = 
    tmp_value = 
    tmp_ajax_action = 
    tmp_params = 
    tmp_url = 
    tmp_id =
    null;

    function refresh_table()
    {
        table.draw();
    }

    function btn_yes_was_clicked()
    {
        if( tmp_ajax_action == 'delete' )
            eliminar_registro_was_clicked( tmp_id );
    }

    function eliminar_registro_was_clicked( id )
    {
        tmp_params = { _method:'DELETE', _token: CSRF_TOKEN };
        tmp_url = URL_ELIMINAR_REGISTRO + id;
        $.post( tmp_url, tmp_params,
        function( response )
        {
            eliminar_avisos_response( response );
        });
    }
    function btn_delete_was_clicked( element )
    {
        tmp_ajax_action = 'delete';
        tmp_id = element.attr('registro');
        show_eliminar_modal();
    }
    function show_eliminar_modal()
    {
        bootstrap_modal_set_datas(
        'CONFIRMACI&#211;N', 
        '<h4 class="text-center">DESEA ELIMINAR LA NOTICIA SELECIONADA?</h4>', 
        'ACEPTAR',
        'CERRAR', 
        'btn btn-danger',
        'btn btn-success'
        );
        BOOTSTRAP_MODAL.modal('show');
    }
    function eliminar_avisos_response( response )
    {
        if( response.error )
            alert( response.message );
        else
            refresh_table();
    }
    function ver_detalles_was_clicked( element )
    {
        //tmp_ajax_action = 'ver-detalle';
        tmp_id = element.attr('registro');
        get_aviso_detalle( );
    }
    function get_aviso_detalle()
    {
        tmp_url = URL_VER_DETALLES+tmp_id;
        $.get(tmp_url,
        function( response )
        {
            ver_detalles_response( response );
        });
    }
    function ver_detalles_response( response )
    {
        open_modal_ver_detalles(response);
    }
    function open_modal_ver_detalles(response = '')
    {
        bootstrap_modal_set_datas('VER DETALLES', response );
        BOOTSTRAP_MODAL.modal('show');
    }
    
    
    function bootstrap_modal_set_datas(title, body, accept_title = null, close_title = 'CERRAR', accept_class = 'btn btn-success', close_class = 'btn btn-danger')
    {
        BOOTSTRAP_MODAL.find(".modal-title").html(title);
        BOOTSTRAP_MODAL.find(".modal-body").html(body);

        if(accept_title)
            BOOTSTRAP_MODAL.find("#confirmation-modal-btn-yes").html(accept_title).attr('class', accept_class).show();
        else
            BOOTSTRAP_MODAL.find("#confirmation-modal-btn-yes").attr('class', accept_class).hide();
        

        BOOTSTRAP_MODAL.find("#confirmation-modal-btn-no").attr('class', close_class).html(close_title);
    }

    function set_ajax_action(action){ tmp_ajax_action = action; }
    
    
</script>