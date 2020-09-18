<div class="box-body">
    <div class="row">

        <div class="col-md-2">
            {!! Form::requiredInput('nombre', 'Nombre', $errors, $colegio) !!}
        </div>

        <div class="col-md-2">
            {!! Form::normalCheckbox('tiene_varias_secciones', 'Tiene varias secciones', $errors, $colegio) !!}
        </div>

        <div class="col-md-2">
            @mediaSingle('imagen', $colegio)
        </div>

    </div>
    
    
</div>
