<script type="text/javascript" charset="utf-8">

    INPUT_BUSCAR_POR_TITULO.keyup(function()
    {
        refresh_table();
    });
    $('.glyphicon.glyphicon-trash').click(function()
    {
        $(this).parent().find('input').val('');
        refresh_table();
    });

    $( document ).on('click', '.btn-noticia-eliminar', function()
    {
        btn_delete_was_clicked( $(this) );
    });
    $( document ).on('click', '.btn-noticia-detalles', function()
	{
        ver_detalles_was_clicked( $(this) );
	});

    TABLE.on( 'draw.dt', function () 
    {
        //inspect_checkboxs();
    });

    INPUT_FECHA_INICIO.on("dp.change, change", function (e) 
    {
        refresh_table();
    });
    INPUT_FECHA_FIN.on("dp.change, change", function (e) 
    {
        refresh_table();
    });
    
    BOOTSTRAP_MODAL_YES_BUTTON.click(function()
    {
        btn_yes_was_clicked();
    });
</script>