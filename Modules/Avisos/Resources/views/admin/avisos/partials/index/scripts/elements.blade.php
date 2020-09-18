<script type="text/javascript" charset="utf-8" defer>
	var BTN_CONTROL_CHECKBOX_TOGGLE = $("#btn-control-checkbox-toogle");
    var BTN_CONTROL_DELETE = $("#btn-control-delete");
    var BTN_CONTROL_PREVIOUS = $("#btn-control-previous");
    var BTN_CONTROL_NEXT = $("#btn-control-next");
    var BTN_CONTROL_REFRESH = $("#btn-control-refresh");
    var TABLE_AVISOS = $("#avisos-table");
    var INPUT_BUSCAR_POR_TITULO = $("#input-search-titulo");
    var INPUT_BUSCAR_FECHA_DESDE = $("#input-fecha-desde");
    var INPUT_BUSCAR_FECHA_HASTA = $("#input-fecha-hasta");
    var URL_ELIMINAR_AVISOS = '{{ route("admin.avisos.aviso.delete_avisos_ajax") }}';
    var URL_VER_DETALLES = '{{ route("admin.avisos.aviso.ver_detalle", ['']) }}';
    var CSRF_TOKEN = '{{ csrf_token() }}';
    var BOOTSTRAP_MODAL = $("#confirmation-modal");
    
    var SELECT_CATEGORIAS = $("#categoria_select");
    var SELECT_GRADOS = $("#grados_select");
    var SELECT_SECCIONES = $("#secciones_select");

    INPUT_BUSCAR_FECHA_DESDE.datepicker(
    {
        changeMonth: true,
        changeYear: true
    });
    INPUT_BUSCAR_FECHA_HASTA.datepicker(
    {
        changeMonth: true,
        changeYear: true
    });

    SELECT_SECCIONES.chained("#"+SELECT_GRADOS.attr('id'));
    SELECT_GRADOS.chained("#"+SELECT_CATEGORIAS.attr('id'));
</script>

