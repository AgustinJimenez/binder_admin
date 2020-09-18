{!! Form::open(['route' => ['api.v1.forgot_password.reset.post', $reset_data->token], 'method' => 'post']) !!}
<div class="container-fluid">
	<h3 class="text-center">{{ $reset_data->email }}</h3>
	<br>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">

			<div class="row">
				<div class="form-group">
					<label>Nueva Contraseña</label>
					<input placeholder="Nueva Contraseña" type="password" name="password" class="form-control" id="password" autocomplete="off" required pattern=".{3,}" title="Minimo 3 letras"/>
				</div>
			</div>

			<div class="row">
				<div class="form-group">
					<label>Repita Contraseña</label>
					<input placeholder="Repita Contraseña" type="password" name="repeat-password" class="form-control" id="repeat-password" autocomplete="off" required pattern=".{3,}" title="Minimo 3 letras"/>
				</div>
			</div>

			<div class="row">
				<input type="submit" class="btn btn-primary btn-block" value="GUARDAR" disabled id="guardar">
			</div>

		</div>
	</div>
</div>

{!! Form::close() !!}
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf-8" async defer>
	$("#password, #repeat-password").keyup(function()
	{
		( $("#password").val() == $("#repeat-password").val() && $("#password").val().length >= 3 && $("#repeat-password").val().length >= 3 ) 
		?
		$("#guardar").attr('disabled', null) 
		: 
		$("#guardar").attr('disabled', 'disabled') ;
	});
</script>

