<script type="text/javascript" charset="utf-8">
    var tmp_responsable_id;
    var tmp_responsable_estado;
    function estado_modal_was_clicked( button )
        {
            tmp_responsable_id = button.attr('responsable_id');
            tmp_responsable_estado = button.text();
            show_estado_modal();
        }

        function button_cambiar_was_clicked( button )
        {
            var button_array_class = button.attr('class').split(" ");
            //last class of button
            tmp_responsable_estado = button_array_class[ button_array_class.length - 1 ];

            if( tmp_responsable_estado  == 'aprobado' )
                show_confirmation_modal();
            else
                cambiar_estado( tmp_responsable_id, tmp_responsable_estado );
        }

        function show_confirmation_modal(html_content)
        {
            $(".modal-body.confirmation-modal").html("</h2 class='text-center'>SEGURO QUE DESEA CAMBIAR EL ESTADO A APROBADO? SE ENVIARA UNA NOTIFICACION.</h2>");
            $("#confirmation-modal").modal("show");
        }

        function hide_confirmation_modal()
        {
            $("#confirmation-modal").modal("hide");
        }

        function button_yes_confirmation_was_clicked()
        {
            cambiar_estado( tmp_responsable_id, tmp_responsable_estado );
        }

        function show_estado_modal()
        {
            $(".button-cambiar").show();
            $(".button-cambiar." + tmp_responsable_estado ).hide();
            $("#estado-modal").modal("show");
        }
        function hide_estado_modal()
        {
            $("#estado-modal").modal("hide");
        }

        function ver_suscripciones_was_clicked( responsable_id )
        {
            var url = "{{ route('admin.responsables.responsable.get_suscripciones', ['']) }}/"+responsable_id;
            console.log(url);
            $.get( url , function( response ) 
            {
                if( response.error != undefined && response.error )
                    console.log( response );
                else
                {
                    open_generic_modal( 
                        "SUSCRIPCIONES", 
                        response, 
                        null
                    );
                }
            });

        }

        function cambiar_estado( id_responsable, nuevo_estado )
        {
            var route = "{{ route('admin.responsables.responsable.update_responsable_ajax', [0]) }}".slice(0, -1) + id_responsable;
            var params = 
            {
                _method: 'PUT',
                _token: "{{ csrf_token() }}",
                responsable:
                {
                    estado: nuevo_estado
                },
                options:
                {
                    notificate_if_aprobado: true
                }
            };
            console.log("SENDING id:" + id_responsable, params);
            $.post( route, params,
            function(data, status)
            {
                console.log("Data: " + data );
                table.draw();
                hide_estado_modal();
            });
            
        }
</script>