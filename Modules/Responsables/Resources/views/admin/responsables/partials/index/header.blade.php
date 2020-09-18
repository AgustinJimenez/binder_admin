<div class="row">

    <div class="col-sm-2">
        <div class="form-group">
            {!! Form::label('nombre', 'Nombre') !!}
            <div class="inner-addon right-addon">
                <i class="glyphicon glyphicon-trash" title="Borrar filtro"></i>
                {!! Form::text('nombre', null, ['class' => 'form-control', 'id' => 'nombre']) !!}
            </div>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="form-group">
            {!! Form::label('apellido', 'Apellido') !!}
            <div class="inner-addon right-addon">
                <i class="glyphicon glyphicon-trash" title="Borrar filtro"></i>
                {!! Form::text('apellido', null, ['class' => 'form-control', 'id' => 'apellido']) !!}
            </div>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="form-group">
            {!! Form::label('email', 'Email') !!}
            <div class="inner-addon right-addon">
                <i class="glyphicon glyphicon-trash" title="Borrar filtro"></i>
                {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
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
<div class="row">
    <div class="col-md-2">
        {!! Form::normalSelect('select-estado', 'Estado', $errors, ['' => '--', 'aprobado' => 'Aprobado', 'pendiente' => 'Pendiente', 'rechazado' => 'Rechazado'] ) !!}
    </div>
</div>