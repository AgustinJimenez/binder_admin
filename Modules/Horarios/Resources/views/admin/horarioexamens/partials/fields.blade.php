<div class="box-body">

    <div class="row">

        <div class="col-md-3">
            {!! Form::normalInput('fecha', 'Fecha', $errors, $horario_examen, ['required' => 'required', 'readonly' => 'readonly', 'style' => 'background-color: white;']) !!}
        </div>

        <div class="col-md-3">
            {!! Form::normalInput('materia', 'Materia', $errors, $horario_examen, ['required' => 'required']) !!}
        </div>

        <div class="col-md-3">
            {!! Form::normalSelect('seccion_id', 'Seccion', $errors, $secciones_list, $horario_examen, ['required' => 'required']) !!} 
        </div>

    </div>
    <div class="row">

        <div class="col-md-12">
            {!! Form::normalTextarea('contenido', 'Contenido', $errors, $horario_examen) !!}
        </div>

    </div>
</div>
<script type="text/javascript" charset="utf-8" defer>
    $(document).ready(function()
    {
        $("#materia").focus();
        $("#fecha").datepicker(
        {
            changeMonth: true,
            changeYear: true
        });
    });
</script>