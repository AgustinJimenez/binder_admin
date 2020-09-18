@php( $columns = ['SECCION', 'IMAGEN', 'ACCIONES'] )

<table class="data-table table table-bordered table-hover">
    <thead class="bg-primary text-center">
        <tr>
            @foreach($columns as $column)
                <th class="text-center">{{ $column }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @if (isset($horarios_clases))
            @foreach ($horarios_clases as $horario_clase)
                <tr class="text-center">
                    <td>
                        <a href="{{ $horario_clase->edit_route }}">
                            {{ $horario_clase->seccion->nombre_grado_seccion }}
                        </a>
                    </td>
                    <td>
                        @if( $horario_clase->imagen )
                            <img src="@thumbnail($horario_clase->imagen->path, 'smallThumb')" alt="" />
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.horarios.horarioclase.edit', [$horario_clase->id]) }}" class="btn btn-default btn-flat">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="{{ $horario_clase->delete_route }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot class="bg-primary text-center">
        <tr>
            @foreach($columns as $column)
                <th class="text-center">{{ $column }}</th>
            @endforeach
        </tr>
    </tfoot>
</table>