@php( $columns = ['FECHA', 'MATERIA', 'CLASE', 'ACCIONES'] )
<table class="data-table table table-bordered table-hover">
    <thead class="bg-primary">
        <tr>
            @foreach( $columns as $column )
                <th class="text-center">{{ $column }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot class="bg-primary">
        <tr>
            @foreach( $columns as $column )
                <th class="text-center">{{ $column }}</th>
            @endforeach
        </tr>
    </tfoot>
</table>