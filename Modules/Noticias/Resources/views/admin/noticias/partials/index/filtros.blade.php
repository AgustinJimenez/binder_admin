<div class="row">

    <div class="col-md-2">
        {!! Form::normalInput('titulo', 'Buscar por Titulo', $errors) !!}
    </div>

    <div class="col-md-2">
        <div class="form-group ">
            <label for="titulo">Fecha Inicio</label>
            <div class="inner-addon right-addon">
                <i class="glyphicon glyphicon-trash" title="Borrar filtro"></i>
                <input placeholder="Fecha Inicio" name="fecha_inicio" type="text" id="fecha_inicio" class="form-control" readonly="readonly" style="background-color: white;">
            </div>
        </div>
    </div>
    
    <div class="col-md-2">
        <div class="form-group ">
            <label for="titulo">Fecha Fin</label>
            <div class="inner-addon right-addon">
                <i class="glyphicon glyphicon-trash" title="Borrar filtro"></i>
                <input placeholder="Fecha Fin" name="fecha_fin" type="text" id="fecha_fin" class="form-control" readonly="readonly" style="background-color: white;">
            </div>
        </div>
    </div>

</div>