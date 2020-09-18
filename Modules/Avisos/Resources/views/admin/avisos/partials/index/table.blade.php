<div class="box box-primary">
    <div class="box-header with-border">

        @include('avisos::admin.avisos.partials.index.header')

    </div>
    <div class="mailbox-controls">
        <button type="button" class="btn btn-default btn-sm checkbox-toggle" id="btn-control-checkbox-toogle"><i class="fa fa-square-o"></i></button>
        <div class="btn-group">
          <button type="button" class="btn btn-sm btn-danger" id="btn-control-delete"><i class="fa fa-trash-o"></i></button>
          <button type="button" class="btn btn-default btn-sm" id="btn-control-previous"><i class="fa fa-reply"></i></button>
          <button type="button" class="btn btn-default btn-sm" id="btn-control-next"><i class="fa fa-share"></i></button>
        </div>
        <button type="button" class="btn btn-default btn-sm" id="btn-control-refresh"><i class="fa fa-refresh"></i></button>
    </div>
    <?php $columns = ['SELECCION', 'FECHA', 'TITULO', 'ENVIADO A / RECIBIDO POR' , 'ACCIONES']?>
    <div class="box-body">
        <div class="table-responsive">
            <table class="data-table table table-bordered table-hover" style="width: 100%;" id="avisos-table">

                <thead>
                    <tr>
                        @foreach ($columns as $column)
                            <th class="bg-primary text-center">{{ $column }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
              
                </tbody>
                <tfoot>
                    <tr>
                        @foreach ($columns as $column)
                            <th class="bg-primary text-center">{{ $column }}</th>
                        @endforeach
                    </tr>
                </tfoot>
            </table>
            <!-- /.box-body -->
        </div>
    </div>
</div>
