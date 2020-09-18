<script type="text/javascript" charset="utf-8" defer>
    var aria_checked = null;
    var clicks = null;
    var checkbox_list = null;
    var checkbox_value = null;
    var tmp_name = null;
    var tmp_value = null;
    var tmp_obj = null;
    var ajax_action = null;
    var params = null;
    var tmp_url = null;
    var tmp_categoria_id;
    var tmp_grado_id;
    var tmp_seccion_id;
    var tmp_window;

    function refresh_table()
    {
        table.draw();
    }

    function show_eliminar_modal()
    {
        bootstrap_modal_set_datas(
        'CONFIRMACI&#211;N', 
        '<h4 class="text-center">DESEA ELIMINAR LOS REGISTROS SELECIONADOS?</h4>', 
        'ACEPTAR',
        'CERRAR', 
        'btn btn-danger',
        'btn btn-success'
        );
        BOOTSTRAP_MODAL.modal('show');
    }

    function eliminar_seleccionados_procedure()
    {
        params = { _method:'DELETE', _token: CSRF_TOKEN, data: checkbox_list };

        $.post(URL_ELIMINAR_AVISOS, params,
        function( response )
        {
            eliminar_avisos_response( response );
        });
    }

    function eliminar_avisos_response( response )
    {
        if( response.error )
            alert( response.message );
        else
            refresh_table();
    }

    function table_next_page()
    {
        table.page( 'next' ).draw( 'page' );
    }

    function set_ajax_action(action)
    {
        ajax_action = action;
    }

    function enviado_recibido_was_clicked( button )
    {
        tmp_categoria_id = ( SELECT_CATEGORIAS.val() != '' ) ? SELECT_CATEGORIAS.val() : '0' ;
        tmp_grado_id = (SELECT_GRADOS.val() != '')?SELECT_GRADOS.val():'0';
        tmp_seccion_id = (SELECT_SECCIONES.val() != '')?SELECT_SECCIONES.val():'0';

        tmp_url = button.attr('href') + '/' + tmp_categoria_id + '/' + tmp_grado_id + '/' + tmp_seccion_id ;
        open_new_tab( tmp_url );
    }

    function open_new_tab( url )
    {
        tmp_window = window.open( url, '_blank');
        tmp_window.focus();
    }

    function btn_delete_was_clicked()
    {
        set_ajax_action( 'delete' );
        update_checkbox_list();
        if( checkbox_list.length )
            show_eliminar_modal();
    }

    function update_checkbox_list()
    {
        checkbox_list = '';
        TABLE_AVISOS.find('input[type=checkbox]').each(function(index)
        {
            tmp_value = ( parseInt( $(this).val() ) )?true:false;
            if( tmp_value )
            {
                tmp_name = parseInt( String(String($(this).attr('name')).split("aviso[").join('')).split("]").join('') );
                //tmp_obj = { id:tmp_name/*, selected:tmp_value*/ };
                if(checkbox_list == '')
                    checkbox_list += tmp_name;//id
                else
                    checkbox_list += ','+tmp_name;//id
            }
            
        });
        //console.log(checkbox_list);
    }

    function table_previous_page()
    {
        table.page( 'previous' ).draw( 'page' );
    }
    function icheckbox_check( element )
    {
        element.addClass('checked').attr('aria-checked', 'true').find('input[type=checkbox]').val(1);
    }
    function icheckbox_discheck( element )
    {
        element.removeClass('checked').attr('aria-checked', 'false').find('input[type=checkbox]').val(0);
    }
    function get_aviso_detalle( id )
    {
        tmp_url = URL_VER_DETALLES+'/'+id+'?ajax=1';
        $.get(tmp_url,
        function( response )
        {
            ver_detalles_response( response );
        });
    
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

    function ver_detalles_response( response )
    {
        open_modal_ver_detalles(response);
    }
    function open_modal_ver_detalles(response = '')
    {
        bootstrap_modal_set_datas('VER DETALLES', response );
        BOOTSTRAP_MODAL.modal('show');
    }

    function icheckbox_toggle_check( element )
    {
        aria_checked = element.attr('aria-checked');
        checkbox_value = element.find('input[type=checkbox]').val();

        element.toggleClass('checked').attr('aria-checked', (aria_checked == 'false')?'true':'false' ).find('input[type=checkbox]').val( (checkbox_value)?0:1 );
    }

    function checkbox_toggle_was_clicked( self )
    {
        clicks = $(self).data('clicks');
        
        $( '#'+TABLE_AVISOS.attr('id') + ' > tbody > tr' ).each(function(index)
        {
            if (clicks) 
            {
                //Uncheck all checkboxes
                $(this).find("input[type='checkbox']").iCheck("check");
                $(".fa", self).removeClass("fa-square-o").addClass('fa-check-square-o');
    
                icheckbox_check( $(this).find('td .icheckbox_flat-blue') );
            } 
            else 
            {
                //Check all checkboxes
                $(this).find("input[type='checkbox']").iCheck("uncheck");
                $(".fa", self).removeClass("fa-check-square-o").addClass('fa-square-o');

                icheckbox_discheck( $(this).find('td .icheckbox_flat-blue') );
            }
        });

        
        $(self).data("clicks", !clicks);
    }
    function btn_control_checkbox_toggle_was_clicked()
    {
        
        $( '#'+TABLE_AVISOS.attr('id') + ' > tbody > tr' ).each(function(index)
        {
            console.log( $(this).find('.icheckbox_flat-blue') );
            $(this).find('.icheckbox_flat-blue').click();
        });
        
    }

</script>