<div class="row">

    <div class="col-md-2">
        <div class="form-group">
            {!! Form::label('fecha_desde_label', 'Fecha Desde') !!}
            <div class="inner-addon right-addon">
                
                <i class="glyphicon glyphicon-trash text-primary"></i>
                <input readonly="readonly" style="background-color: white;" type="text" class="form-control input-sm" placeholder="Desde:" id="input-fecha-desde" name="fecha_desde" value="{{ old('fecha_desde', $fecha_una_semana_antes->format('d/m/Y') ) }}">
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            {!! Form::label('fecha_hasta_label', 'Fecha Hasta') !!}
            <div class="inner-addon right-addon">
                
                <i class="glyphicon glyphicon-trash text-primary"></i>
                <input readonly="readonly" style="background-color: white;" type="text" class="form-control input-sm" placeholder="Hasta:" id="input-fecha-hasta" name="fecha_hasta" value="{{ old('fecha_hasta', $fecha_hoy->format('d/m/Y') ) }}">
                
            </div>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            {!! Form::label('fecha_hasta_label', 'Buscar por Titulo') !!}
            <div class="inner-addon right-addon">
                
                <i class="glyphicon glyphicon-search text-primary"></i>
                <input type="text" class="form-control input-sm" placeholder="Buscar por Titulo" id="input-search-titulo">
                
            </div>
        </div>
    </div>


    <div class="col-sm-2">  
        <div class="form-group">
            {!! Form::label('categoria', 'Categoria') !!}
            <select class="form-control" id="categoria_select" name="categoria_select">
                <option value="">--</option>
                @foreach ($categorias as $categoria)
                    <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-2">  
        <div class="form-group">
            {!! Form::label('grado', 'Grado') !!}
            <select class="form-control" id="grados_select" name="grados_select">
                <option value="">--</option>
                @foreach ($categorias as $categoria)
                    @foreach ($categoria->grados as $grado)
                        <option class="{{$grado->categoria->id}}" value="{{$grado->id}}">{{$grado->nombre}}</option>
                    @endforeach
                @endforeach
            </select>
        </div>
    </div>


    <div class="col-sm-2">  
        <div class="form-group">
            {!! Form::label('seccion', 'Seccion') !!}
            <select class="form-control" id="secciones_select" name="secciones_select">
                <option value="">--</option>
                @foreach ($categorias as $categoria)
                    @foreach ($categoria->grados as $grado)
                        @foreach ($grado->secciones as $seccion)
                            <option class="{{$seccion->grado->id}}" value="{{$seccion->id}}">{{$seccion->nombre}}</option>
                        @endforeach
                    @endforeach
                @endforeach
            </select>
        </div>
    </div>

</div>