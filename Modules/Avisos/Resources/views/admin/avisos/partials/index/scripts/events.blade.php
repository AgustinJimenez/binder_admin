<script type="text/javascript" charset="utf-8" defer>

    BTN_CONTROL_REFRESH.click(function()
    {
        refresh_table();
    });
    
    BTN_CONTROL_CHECKBOX_TOGGLE.click(function () 
    {
        checkbox_toggle_was_clicked( this );
    });
    
    BTN_CONTROL_NEXT.click(function()
    {
        table_next_page();
    });
    BTN_CONTROL_PREVIOUS.click(function()
    {
        table_previous_page();
    });

    INPUT_BUSCAR_POR_TITULO.keyup(function()
    {
        refresh_table();
    });

    $( document ).on('click', '.ver-detalle', function()
	{
        get_aviso_detalle( $(this).attr('aviso') );
	});
    $( document ).on('click', '.button-enviado-recibido', function(event)
	{
        event.preventDefault();
        enviado_recibido_was_clicked( $(this) );
	});
    

    TABLE_AVISOS.on( 'draw.dt', function () 
    {
        //inspect_checkboxs();
    });

    INPUT_BUSCAR_FECHA_DESDE.change(function()
    {
        refresh_table();
    });
    INPUT_BUSCAR_FECHA_HASTA.change(function()
    {
        refresh_table();
    });
    BTN_CONTROL_DELETE.click(function()
    {
        btn_delete_was_clicked();
    });
    /*
    SELECT_CATEGORIAS.change(function()
    {
        console.log("here1");
        refresh_table();
    });
    */
    SELECT_GRADOS.change(function()
    {
        console.log("here2");
        refresh_table();
    });
    SELECT_SECCIONES.change(function()
    {
        console.log("here3");
        refresh_table();
    });
    
    $("#confirmation-modal-btn-yes").click(function()
    {
        eliminar_seleccionados_procedure();
    });

    $(".glyphicon-trash").click(function()
    {
        console.log('clicked', $(this).prev("input") );
        $(this).next("input").val('');
        refresh_table();
    });

    
/*
    $( document ).on('click', '.icheckbox_flat-blue', function()
	{
        icheckbox_toggle_check( $(this) );
	});

    */
</script>