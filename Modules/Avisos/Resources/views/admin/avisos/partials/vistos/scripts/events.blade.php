<script type="text/javascript" charset="utf-8" defer>

    INPUT_BUSCAR_POR_NOMBRE_APELLIDO.keyup(function()
    {
        refresh_table();
    });

    SELECT_VISTO.change(function()
    {
        refresh_table();
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
    SELECT_VISTO.change(function()
    {
        refresh_table();
    });
    SELECT_ESTADO.change(function()
    {
        refresh_table();
    });

    
/*
    $( document ).on('click', '.icheckbox_flat-blue', function()
	{
        icheckbox_toggle_check( $(this) );
	});

    */
</script>