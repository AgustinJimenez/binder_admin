<script type="text/javascript" charset="utf-8">
    var TABLE = $("#table-noticias");
    var URL_ELIMINAR_REGISTRO = '{{ route("admin.noticias.noticia.destroy_ajax", []) }}/';
    var URL_VER_DETALLES = '{{ route("admin.noticias.noticia.ver_detalles", [""]) }}/';
    var CSRF_TOKEN = '{{ csrf_token() }}';
    var BOOTSTRAP_MODAL = $("#confirmation-modal");
    var BOOTSTRAP_MODAL_YES_BUTTON = $("#confirmation-modal-btn-yes");
    var INPUT_BUSCAR_POR_TITULO = $("#titulo");
    var INPUT_FECHA_INICIO = $("#fecha_inicio");
    var INPUT_FECHA_FIN = $("#fecha_fin");
    INPUT_FECHA_INICIO.datepicker(
    {
        changeMonth: true,
        changeYear: true
    });
    INPUT_FECHA_FIN.datepicker(
    {
        changeMonth: true,
        changeYear: true
    });
    
</script>

