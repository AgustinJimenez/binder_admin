<div class="box box-primary">
    <div class="box-header with-border">
        @include('avisos::admin.avisos.partials.vistos.header')
    </div>

    <?php $columns = ['#', 'NOMBRE', 'APELLIDO', 'TIPO ENCARGADO' , 'TELEFONO', 'EMAIL', 'ESTADO', 'LEIDO']?>
    <div class="box-body">
        <div class="table-responsive">
            <table class="data-table table table-bordered table-hover" style="width: 100%;" id="vistos-table">
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
        </div>
    </div>
</div>