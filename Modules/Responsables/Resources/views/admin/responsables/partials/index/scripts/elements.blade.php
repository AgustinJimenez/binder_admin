<script type="text/javascript" charset="utf-8">
    var SELECT_CATEGORIAS = $("#categoria_select");
    var SELECT_GRADOS = $("#grados_select");
    var SELECT_SECCIONES = $("#secciones_select");
    var SELECT_ESTADO = $("#select-estado");
    var INPUT_NOMBRE = $("#nombre");
    var INPUT_APELLIDO = $("#apellido");
    var INPUT_EMAIL = $("#email");

    SELECT_SECCIONES.chained("#"+SELECT_GRADOS.attr('id'));
    SELECT_GRADOS.chained("#"+SELECT_CATEGORIAS.attr('id'));

</script>