
<div class="container-fluid">
    <div class="row">

        <div class="col-md-6">
            {!! Form::normalInput('titulo', 'Titulo', $errors, $noticia, isset($params['general_attributes'])?$params['general_attributes']:['required' => 'required']) !!}
        </div>

        <div class="col-md-6">
            {!! Form::normalInput('fecha', 'Fecha', $errors, $noticia, array('readonly' => 'readonly', 'style' => 'background-color: white;', 'required' => 'required')) !!}
        </div>

    </div>
    @if( !$noticia->id or  isset( $noticia->archivo ) and !isset($params['contenido_plain']) )
    <hr>
        <div class="row">
            <div class="col-md-2 col-md-offset-10">
                @mediaSingle('archivo', $noticia)
            </div>
        </div>
    <hr>
    @endif
    @if( $noticia->archivo and isset($params['contenido_plain']) )
        <hr>
            <div class="row">
                <div class="col-md-2 col-md-offset-8">
                    <img src="@thumbnail($noticia->archivo->path, 'mediumThumb')" height="150px">
                </div>
            </div>
        <hr>
    @endif

    <div class="row">
        
        <div class="col-md-12 text-center">

            @if( isset( $params['contenido_plain'] ) )

                {!! $noticia->contenido !!}

            @else

                {!! Form::normalTextarea('contenido', 'Contenido', $errors, $noticia, isset($params['general_attributes'])?$params['general_attributes']:['required' => 'required']) !!}

            @endif

        </div>

    </div>
<div>