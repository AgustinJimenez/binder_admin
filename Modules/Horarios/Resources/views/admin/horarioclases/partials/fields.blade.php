<div class="row">

    <div class="col-md-3">

        {!! Form::normalSelect('seccion_id', 'Seccion', $errors, $secciones_list, $horario_clase, ['required' => 'required']) !!} 

    </div>

    <div class="col-md-2">
        @mediaSingle('imagen', $horario_clase)
    </div>

</div>