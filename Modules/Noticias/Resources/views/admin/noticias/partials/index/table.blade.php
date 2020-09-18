<?php $columns = ['FECHA', 'TITULO', 'ACCIONES']?>
<div class="table-responsive">
    <table class="data-table table table-bordered table-hover" id="table-noticias">
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