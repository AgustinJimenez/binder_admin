<script type="text/javascript" charset="utf-8">
    $.fn.dataTable.ext.errMode = 'none';
	var table = $('.data-table').DataTable
	({
      	dom: config.datatable.tool_bar,
        deferRender: true,
        processing: true,
        serverSide: true,
        order: config.datatable.order,
        paginate: true,
        lengthChange: true,
        iDisplayLength: config.datatable.default_datas_count,
        filter: true,
        sort: false,
        info: true,
        autoWidth: true,
        paginate: true,
        initComplete: config.datatable.initComplete,
        //"drawCallback": reordenar_celdas(),
        ajax: 
        {
            url: config.datatable.ajax_source,
            type: "POST",
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            data: config.datatable.send_request,
            dataSrc: config.datatable.data_source,
        },
        columns: config.datatable.columns,
        language: 
        {
            processing:     "Procesando...",
            search:         "Buscar",
            lengthMenu:     "Mostrar _MENU_ Elementos",
            info:           "Mostrando de _START_ a _END_ registros de un total de _TOTAL_ registros",
            //infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            infoFiltered:   ".",
            infoPostFix:    "",
            loadingRecords: "Cargando Registros...",
            zeroRecords:    "No existen registros disponibles",
            emptyTable:     "No existen registros disponibles",
            paginate: 
            {
                first:      "Primera",
                previous:   "<i class='fa fa-chevron-left'></i>",
                next:       "<i class='fa fa-chevron-right'></i>",
                last:       "Ultima"
            }
        } 
    });
</script>