<div class="modal fade" id="modal-colegio" tabindex="-1" role="dialog" aria-labelledby="colegio-title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="colegio-title">Establecer Colegio</h4>
            </div>
            <div class="modal-body">
                <div class="default-message">
                    Está seguro que desea cambiar el valor de la variable de sesión del colegio?
                </div>
                <div class="custom-message"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-flat" data-dismiss="modal">Cancelar</button>
                {!! Form::open(['method' => 'post', 'class' => 'pull-left']) !!}
                    <button type="submit" class="btn btn-primary btn-flat">Aceptar</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@push('js-stack')
<script>
    $( document ).ready(function()
    {
        $('#modal-colegio').on('show.bs.modal', function (e)
        {
            var button = $(e.relatedTarget);
            $(this).find('form').attr('action', button.data('action-target'));
        });
    });
</script>
@endpush