<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Redactar nuevo aviso</h3>
	</div>
	
	<div class="box-body">

		<div class="row">

			<div class="col-md-8">
				<div class="form-group">
					<input class="form-control" placeholder="Título:" value="{{ old('titulo', $aviso->titulo) }}" name="titulo" required="required" autocomplete="off">
				</div>
			</div>

			<div class="col-md-4">
				<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" class="form-control pull-right" placeholder="Fecha:" value="{{ old('fecha', ($aviso->fecha)?$aviso->fecha:date('d/m/Y')) }}" name="fecha" required="required" id="fecha" readonly="" style="background-color: #FFF!important;" autocomplete="off">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{!! Form::normalTextarea('contenido', '  ', $errors, $aviso) !!}
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
		        @mediaSingle('archivo', $aviso/*, 'avisos::admin.avisos.partials.media-button'*/)
	        </div>
	        
        </div>
        <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <input class="form-control" placeholder="Firma:" required="required" name="firma" value="{{ old('firma', $aviso->firma) }}" autocomplete="off">
              </div>
            </div>
        </div>
        
        <input type="hidden" name="tipo" value="{{ old('tipo', (isset($aviso->tipo) ? $aviso->tipo : $tipo)) }}" autocomplete="off">

        <a class="btn btn-danger btn-flat" href="{{ route('admin.avisos.aviso.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-envelope-o"></i> Enviar</button>
	</div>
