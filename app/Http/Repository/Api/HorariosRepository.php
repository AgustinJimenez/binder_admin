<?php namespace App\Http\Repository\Api;

class HorariosRepository
{
    public $custom_horario_examen_repo;
    public $custom_horario_clase_repo;

    public function __construct( 
        \CustomHorarioExamenRepository $custom_horario_examen_repo,
        \CustomHorarioClaseRepository $custom_horario_clase_repo
    )
    {
        $this->custom_horario_examen_repo = $custom_horario_examen_repo;
        $this->custom_horario_clase_repo = $custom_horario_clase_repo;
    }

    public function app_examenes_index( $seccion_id, $skip = 0 )
    {
        return $this->custom_horario_examen_repo
        ->query_get_horarios_examenes_from_seccion_id( $seccion_id )
        ->orderBy('fecha', 'DESC')
        ->skip( $skip )
        ->take(5);
    }

    public function app_clases_index( $seccion_id, $skip = 0 )
    {
        return $this->custom_horario_clase_repo
        ->query_get_horarios_clases_from_seccion_id( $seccion_id )
        ->with(['seccion:id,nombre,grado_id', 'seccion.grado:id,nombre,orden'])
        ->skip( $skip )
        ->take(5);
    }
}