<div class="box-body">
	<div class="row">
		<div class="col-sm-12 col-sm-4">
			{!! Form::requiredInput('nombre', 'Nombre', $errors, $grado) !!}
		</div>
		<div class="col-sm-12 col-sm-4">
			{!! Form::requiredSelect('categoria_id', 'Categoria', $errors, \Helper::addDefaultOptionArray($categorias), $grado) !!}
		</div>
		<div class="col-sm-12 col-md-4">
			{!! Form::normalInput('orden', 'Orden', $errors, $grado, ['required' => "required", 'min' => '0']) !!}
			<script>$("#orden").attr("type", "number")</script>
		</div>
	</div>
</div>
