<div class="row">
    
    <div class="col-md-2">

        <div class="form-group">
            {!! Form::label('fecha_inicio', 'Fecha Desde') !!}
            <div class="inner-addon right-addon">
                <i class="glyphicon glyphicon-trash" title="Fecha Desde"></i>
                {!! Form::text('fecha_inicio', null, ['class' => 'form-control', 'id' => 'fecha_inicio']) !!}
            </div>
        </div>

    </div>

    <div class="col-md-2">

        <div class="form-group">
            {!! Form::label('fecha_fin', 'Fecha Fin') !!}
            <div class="inner-addon right-addon">
                <i class="glyphicon glyphicon-trash" title="Fecha Fin"></i>
                {!! Form::text('fecha_fin', null, ['class' => 'form-control', 'id' => 'fecha_fin']) !!}
            </div>
        </div>


    </div>

    <div class="col-md-2">

        <div class="form-group">
            {!! Form::label('materia', 'Materia') !!}
            <div class="inner-addon right-addon">
                <i class="glyphicon glyphicon-trash" title="Materia"></i>
                {!! Form::text('materia', null, ['class' => 'form-control', 'id' => 'materia']) !!}
            </div>
        </div>

    </div>

</div>