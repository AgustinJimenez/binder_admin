<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repository\Api\HorariosRepository;

class Horarios extends Controller
{
    private $repo;

    public function __construct(HorariosRepository $repo)
    {
        $this->repo = $repo;
    }

    public function get_examenes_index(Request $re)
    {
        return ['error' => false, 'data' => array('horarios_examenes' => $this->repo->app_examenes_index( $re->seccion_id, $re->skip )->get()->toArray() ) ];
    }

    public function get_clases_index(Request $re)
    {
        return ['error' => false, 'data' => array('horarios_clases' => $this->repo->app_clases_index( $re->seccion_id, $re->skip )->get()->toArray() ) ];
    }

    public function get_horario_examen_by_id( Request $re )
    {
        $horario_examen = $this->repo->custom_horario_examen_repo->horarios_examenes->find( $re->id );

        if( !$horario_examen )
            return ['error' => true, 'message' => "No se encuentra el horario de examen solicitado."];
        else
            return ['error' => false, 'data' => array('horario_examen' => $horario_examen) ];
    }

    public function get_horario_clase_by_id( Request $re )
    {
        $horario_clase = $this->repo->custom_horario_clase_repo->horarios_clases->find( $re->id );

        if( !$horario_clase )
            return ['error' => true, 'message' => "No se encuentra el horario de clase solicitado."];
        else
            return ['error' => false, 'data' => array('horario_clase' => $horario_clase) ];
    }

    

}

