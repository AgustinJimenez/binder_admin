<div class="box-body">
    <div class="col-sm-12 col-md-3">
    	{!! Form::requiredInput('nombre', 'Nombre', $errors, $alumno, ['required' => 'required']) !!}
    </div>
    <div class="col-sm-12 col-md-3">
    	{!! Form::requiredInput('apellido', 'Apellido', $errors, $alumno, ['required' => 'required']) !!}
    </div>
    <div class="col-sm-12 col-md-3">
    	{!! Form::normalInput('fecha_nacimiento', 'Fecha de Nacimiento', $errors, $alumno, ['readonly' => 'readonly','style' => 'background-color: #FFF!important;']) !!}
    </div>
    <div class="col-sm-12 col-md-3">
    	{!! Form::normalInput('ci', 'C.I.', $errors, $alumno) !!}
    </div>
    <div class="col-sm-12 col-md-6">
    	{!! Form::requiredSelect('grado_id', 'Grado', $errors, \Helper::addDefaultOptionArray($grados), $alumno, ['id' => 'grado_id']) !!}
    </div>
    {!! Form::hidden('user_id', $alumno->user->id) !!}
    @if(\Helper::colegioTieneVariasSecciones())
	    <div class="col-sm-12 col-md-6">
	    	{!! Form::requiredSelect('seccion_id', 'Sección', $errors, \Helper::addDefaultOptionArray($secciones), $alumno, ['id' => 'seccion_id', 'required' => 'required']) !!}
	    </div>
    @endif
    <div class="col-md-12 text-center">
        <h3 style="margin-top: 10px;">Usuario</h3>
    </div>
    <div class="col-sm-12 col-md-4">
        {!! Form::requiredInput('email', 'Email', $errors, $alumno->user) !!}
    </div>
{{-- 
    @if($alumno->user)
        <div class="col-sm-12 col-md-4">
        	{!! $alumno->user->html_edit_button() !!}
        </div>
    @endif
--}}
</div>