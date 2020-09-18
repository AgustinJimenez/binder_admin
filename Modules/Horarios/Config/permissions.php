<?php

return [
    'horarios.horarioclases' => [
        'index' => 'horarios::horarioclases.list resource',
        'create' => 'horarios::horarioclases.create resource',
        'edit' => 'horarios::horarioclases.edit resource',
        'destroy' => 'horarios::horarioclases.destroy resource',
    ],
    'horarios.horarioexamens' => [
        'index' => 'horarios::horarioexamens.list resource',
        'create' => 'horarios::horarioexamens.create resource',
        'edit' => 'horarios::horarioexamens.edit resource',
        'destroy' => 'horarios::horarioexamens.destroy resource',
        'index_ajax' => 'horarios::horarioexamens.index_ajax resource',
    ],
// append


];
