<div class="box-body">
    <div class="col-sm-12 col-md-3">
    	{!! Form::requiredInput('nombre', 'Nombre', $errors, $responsable) !!}
    </div>
    <div class="col-sm-12 col-md-3">
    	{!! Form::requiredInput('apellido', 'Apellido', $errors, $responsable) !!}
    </div>
    <div class="col-sm-12 col-md-3">
    	{!! Form::normalInput('telefono', 'Teléfono', $errors, $responsable) !!}
    </div>
    <div class="col-sm-12 col-md-3">
        {!! Form::normalInput('ci', 'C.I.', $errors, $responsable) !!}
    </div>
    <div class="col-md-12 text-center">
    	<h3 style="margin-top: 10px;">Usuario</h3>
    </div>
    {!! Form::hidden('user_id', $responsable->user->id) !!}
    <div class="col-sm-12 col-md-4">
    	{!! Form::requiredInput('email', 'Email', $errors, $responsable->user) !!}
    </div>
{{-- 
{!! $responsable->user->html_edit_button() !!}
 --}}
        

</div>