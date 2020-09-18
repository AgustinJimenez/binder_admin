<div class="box-body">
		<div class="col-sm-12 col-md-4">
			{!! Form::requiredInput('nombre', 'Nombre', $errors) !!}
		</div>
		<div class="col-sm-12 col-md-4">
			{!! Form::requiredSelect('categoria_id', 'Categoria', $errors, \Helper::addDefaultOptionArray($categorias)) !!}
		</div>
		<div class="col-sm-12 col-md-4">
			{!! Form::normalInput('orden', 'Orden', $errors, (object)['orden' => 0], ['required' => "required", 'min' => '0']) !!}
			<script>$("#orden").attr("type", "number")</script>
		</div>
</div>
