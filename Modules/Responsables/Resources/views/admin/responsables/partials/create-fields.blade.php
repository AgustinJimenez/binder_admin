<div class="box-body">
    <div class="col-sm-12 col-md-3">
    	{!! Form::requiredInput('nombre', 'Nombre', $errors) !!}
    </div>
    <div class="col-sm-12 col-md-3">
    	{!! Form::requiredInput('apellido', 'Apellido', $errors) !!}
    </div>
    <div class="col-sm-12 col-md-3">
    	{!! Form::normalInput('telefono', 'Teléfono', $errors) !!}
    </div>
    <div class="col-sm-12 col-md-3">
        {!! Form::normalInput('ci', 'C.I.', $errors) !!}
    </div>
    <div class="col-md-12 text-center">
    	<h3 style="margin-top: 10px;">Usuario</h3>
    </div>
    <div class="col-sm-12 col-md-4">
    	{!! Form::requiredInput('email', 'Email', $errors) !!}
    </div>
    <div class="col-sm-4">
	    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	        {!! Form::label('password', trans('user::users.form.password')) !!}
	        {!! Form::password('password', ['class' => 'form-control', 'required' => 'required']) !!}
	        {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
	    </div>
	</div>
	<div class="col-sm-4">
	    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
	        {!! Form::label('password_confirmation', trans('user::users.form.password-confirmation')) !!}
	        {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => 'required']) !!}
	        {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
	    </div>
	</div>
</div>