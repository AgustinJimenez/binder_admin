<?php

return 
[
    'responsables.responsables' => 
    [
        'index' => 'responsables::responsables.list resource',
        'create' => 'responsables::responsables.create resource',
        'edit' => 'responsables::responsables.edit resource',
        'destroy' => 'responsables::responsables.destroy resource',
        'update_responsable_ajax' => 'responsables::responsables.update_responsable_ajax resource',   
        'get_suscripciones' => 'responsables::responsables.get_suscripciones resource',
    ]

];
