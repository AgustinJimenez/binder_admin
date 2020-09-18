<script type="text/javascript" charset="utf-8" defer>

    INPUT_MATERIA.keyup(function()
    {
        refresh_table();
    });
    $('.glyphicon.glyphicon-trash').click(function()
    {
        $(this).parent().find('input').val('');
        refresh_table();
    });

    TABLE.on( 'draw.dt', function () 
    {
        //inspect_checkboxs();
    });

    INPUT_FECHA_INICIO.on("change", function (e) 
    {
        refresh_table();
    });
    INPUT_FECHA_FIN.on("change", function (e) 
    {
        refresh_table();
    });

</script>