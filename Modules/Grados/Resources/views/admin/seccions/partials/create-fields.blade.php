<div class="box-body">
	<div class="col-sm-12 col-md-6">
		{!! Form::requiredInput('nombre', 'Nombre', $errors) !!}
	</div>
	<div class="col-sm-12 col-md-6">
		{!! Form::requiredSelect('grado_id', 'Grado', $errors, \Helper::addDefaultOptionArray($grados)) !!}
	</div>
</div>