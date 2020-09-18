<script type="text/javascript" charset="utf-8" defer>
    var URL_ELIMINAR_REGISTRO = '{{ route("admin.horarios.horarioexamen.destroy", ['']) }}/';
    var INPUT_MATERIA = $("#materia");
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

