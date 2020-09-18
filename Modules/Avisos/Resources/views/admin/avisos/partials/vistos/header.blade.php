<div class="row">

    <div class="col-sm-3">  
        <div class="form-group">
            {!! Form::label('categoria', 'Categoria') !!}
            <select class="form-control" id="categoria_select" name="categoria_select">
                <option value="">--</option>
                @foreach ($categorias_del_aviso as $categoria)
                    <option value="{{$categoria->id}}" {{ ($categoria_seleccionada->id == $categoria->id)?'selected="selected"':'' }} >{{$categoria->nombre}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-3">  
        <div class="form-group">
            {!! Form::label('grado', 'Grado') !!}
            <select class="form-control" id="grados_select" name="grados_select">
                <option value="">--</option>
                @foreach ($categorias_del_aviso as $categoria)
                    @foreach ($categoria->grados as $grado)
                        <option class="{{$grado->categoria->id}}" value="{{$grado->id}}" {{ ($grado_seleccionado->id == $grado->id)?'selected="selected"':'' }}>{{$grado->nombre}}</option>
                    @endforeach
                @endforeach
            </select>
        </div>
    </div>


    <div class="col-sm-3">  
        <div class="form-group">
            {!! Form::label('seccion', 'Seccion') !!}
            <select class="form-control" id="secciones_select" name="secciones_select">
                <option value="">--</option>
                @foreach ($categorias_del_aviso as $categoria)
                    @foreach ($categoria->grados as $grado)
                        @foreach ($grado->secciones as $seccion)
                            <option class="{{$seccion->grado->id}}" value="{{$seccion->id}}" {{ ($seccion_seleccionada->id == $seccion->id)?'selected="selected"':'' }}>{{$seccion->nombre}}</option>
                        @endforeach
                    @endforeach
                @endforeach
            </select>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-sm-3">  
        {!! Form::normalInput('input-search-nombre-apellido', 'Nombre/Apellido', $errors ) !!}
    </div>

    <div class="col-sm-2">  
        {!! Form::normalSelect('select-visto', 'Leído', $errors, ['' => '--', 'si' => 'SI', 'no' => 'NO'] ) !!}
    </div>
    <div class="col-md-2">
        {!! Form::normalSelect('select-estado', 'Estado', $errors, ['' => '--', 'aprobado' => 'Aprobado', 'pendiente' => 'Pendiente', 'rechazado' => 'Rechazado'] ) !!}
    </div>

</div>