<div id="generic-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"></h4>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer bg-primary">
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
    /*
    open_generic_modal( 
        "SUSCRIPCIONES", 
        response, 
        null
    );
    */
    function open_generic_modal
    ( 
        title_content = null, 
        body_content = null, 
        footer_content = null, 
        no_button_title = 'CERRAR',
        no_button_class = 'btn btn-danger',
        yes_button = false, 
        yes_button_title = 'ACEPTAR'
    )
    {
        if( !title_content )
            title_content = 'SUSCRIPCIONES';

        if( !body_content )
            body_content = '';

        if( !footer_content )
        {
            footer_content = 
            ((yes_button) ? ('<button type="button" class="btn btn-default btn-yes" data-dismiss="modal">' + yes_button_title + '</button>') : '')+
            '<button type="button" class="' + no_button_class + '" data-dismiss="modal">' + no_button_title + '</button>';
        }

        $("#generic-modal").find(".modal-title").html( title_content );
        $("#generic-modal").find(".modal-body").html( body_content );
        $("#generic-modal").find(".modal-footer").html( footer_content );
        $("#generic-modal").modal("show");

    }

</script>