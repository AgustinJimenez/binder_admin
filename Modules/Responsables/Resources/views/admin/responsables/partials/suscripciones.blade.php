@if( $categorias_suscripciones->count() )

<div style="overflow-y: auto; max-height: 250px;" class="text-center">
    @foreach ($categorias_suscripciones as $categoria)
        <div class="box box-primary collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">{{ $categoria->nombre }}</h3>
                <div class="box-tools">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" onclick="toggle_collapse( $(this) )">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body no-padding mailbox-messages">
                <ul class="nav nav-pills nav-stacked">
                    @foreach( $categoria->grados as $grado )
                        <li>
                            <div class="box box-warning collapsed-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">{{ $grado->nombre }}</h3>
                                    <div class="box-tools">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse" onclick="toggle_collapse( $(this) )">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body no-padding mailbox-messages">
                                    <ul class="nav nav-pills nav-stacked">
                                        @foreach( $grado->secciones as $seccion )
                                            <li>
                                                <a href="#">
                                                    <i class="fa fa-graduation-cap"></i> 
                                                    {{ $seccion->nombre }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>	
        </div>
    @endforeach
</div>

@endif


<script type="text/javascript">
    function toggle_collapse( element )
    {
        element.find('i').toggleClass( "fa-plus fa-minus" ).closest('.with-border').next('.box-body').toggle();
    }
</script>