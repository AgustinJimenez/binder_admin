<script type="text/javascript" charset="utf-8">
$( document ).ready(function()
{

    SELECT_SECCIONES.change(function()
    {
        table.draw();
    });
    SELECT_GRADOS.change(function()
    {
        table.draw();
    });
    SELECT_ESTADO.change(function()
    {
        table.draw();
    });
    INPUT_NOMBRE.keyup(function()
    {
        table.draw();
    });
    INPUT_APELLIDO.keyup(function()
    {
        table.draw();
    });
    INPUT_EMAIL.keyup(function()
    {
        table.draw();
    });
    
    $(".btn-yes").click(function()
    {
        button_yes_confirmation_was_clicked();   
    });
    $(".button-cambiar").click(function()
    {
        button_cambiar_was_clicked( $(this) );
    });

    $('body').on('click', ".estado-modal", function()
    {
        estado_modal_was_clicked( $(this) );
    });

    $('body').on('click', ".responsable-ver-suscripciones", function()
    {
        ver_suscripciones_was_clicked( $(this).attr('responsable_id') );
    });

    $('.glyphicon.glyphicon-trash').click(function()
    {
        $(this).parent().find('input').val('');
        table.draw();
    });

    

    $(document).keypressAction({actions: [{ key: 'c', route: "{{ route('admin.responsables.responsable.create') }}" }]});
});
</script>