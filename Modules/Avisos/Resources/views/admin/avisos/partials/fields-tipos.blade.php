
@if( $tipo != 'por_seccion' )
<!--POR GRADO/CATEGORIA-->
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">{{ $titulo }}</h3>

			<div class="box-tools">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
				</button>
			</div>

		</div>
		<div class="box-body">
			<div class="box-body no-padding mailbox-messages">
				<ul class="nav nav-pills nav-stacked" style="overflow-y: auto; max-height: 500px;">
					@foreach( $tipos_collection as $id => $tipo_nombre )
						<li>
							<a href="#">
								<div class="row">
									<div class="col-md-1">
										<i class="fa fa-graduation-cap"></i> 
									</div>
									<div class="col-md-8">
										{{ $tipo_nombre }}
									</div>
									<div class="col-md-2">
										<span class="label pull-right" style="margin-top: -10px;">
											{!! Form::normalCheckbox( $nombre_field . '[' . $id . ']', ' ', $errors ) !!}
										</span>
									</div>
								</div>
							</a>
						</li>
					@endforeach
				</ul>
			</div>
		</div>		
	</div>
<!--POR SECCION-->
@else
	<div style="overflow-y: auto; max-height: 500px;">
		@foreach ($tipos_collection as $grado)
			<div class="box box-primary collapsed-box">
				<div class="box-header with-border">
					<h3 class="box-title">{{ $grado->nombre }}</h3>
					<div class="box-tools">
						<button type="button" class="btn btn-box-tool" data-widget="collapse">
							<i class="fa fa-plus"></i>
						</button>
					</div>
				</div>
				<div class="box-body no-padding mailbox-messages">
					<ul class="nav nav-pills nav-stacked">
						@foreach( $grado->secciones as $seccion )
							<li>
								<a href="#">
									<div class="row">
										<div class="col-md-1">
											<i class="fa fa-graduation-cap"></i> 
										</div>
										<div class="col-md-9">
											{{ $seccion->nombre }}
										</div>
										<div class="col-md-1">
											<span class="label pull-right" style="margin-top: -10px;">
											{!! Form:: normalCheckbox( $nombre_field . '[' . $seccion->id . ']', ' ', $errors ) !!}
											</span>
										</div>
									</div>
								</a>
							</li>
						@endforeach
					</ul>
				</div>	
			</div>
		@endforeach
	</div>
@endif