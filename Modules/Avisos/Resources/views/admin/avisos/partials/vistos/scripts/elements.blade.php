<script type="text/javascript" charset="utf-8" defer>
    var TABLE_VISTOS = $("#vistos-table");
    var INPUT_BUSCAR_POR_NOMBRE_APELLIDO = $("#input-search-nombre-apellido");
    var SELECT_VISTO = $("#select-visto");
    var INPUT_BUSCAR_FECHA_HASTA = $("#input-fecha-hasta");
    var URL_ELIMINAR_AVISOS = '{{ route("admin.avisos.aviso.delete_avisos_ajax") }}';
    var URL_VER_DETALLES = '{{ route("admin.avisos.aviso.ver_detalle", ['']) }}';
    var CSRF_TOKEN = '{{ csrf_token() }}';
    var BOOTSTRAP_MODAL = $("#confirmation-modal");
    
    var SELECT_ESTADO = $("#select-estado")
    var SELECT_CATEGORIAS = $("#categoria_select");
    var SELECT_GRADOS = $("#grados_select");
    var SELECT_SECCIONES = $("#secciones_select");

    SELECT_SECCIONES.chained("#"+SELECT_GRADOS.attr('id'));
    SELECT_GRADOS.chained("#"+SELECT_CATEGORIAS.attr('id'));
</script>

