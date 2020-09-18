<?php namespace Modules\Horarios\Repositories;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomHorarioClaseRepository
{
    public $custom_seccion_repo;
    public $error_repo;
    public $custom_colegio_repo;
    public $horarios_clases;

    public function __construct( \HorarioClase $horarios_clases, \CustomSeccionRepository $custom_seccion_repo, \ErrorsRepository $error_repo, \CustomColegioRepository $custom_colegio_repo )
    {
        $this->custom_seccion_repo = $custom_seccion_repo;
        $this->error_repo = $error_repo;
        $this->custom_colegio_repo = $custom_colegio_repo;
        $this->horarios_clases = $horarios_clases;
    }

    public function get()
    {
        return $this->horarios_clases->get();
    }

    public function clases_by_colegio_session()
    {
        return $this->horarios_clases->whereHas('seccion.grado.categoria.colegio', function( $colegio_q )
        {
            $colegio_q->where('token', $this->custom_colegio_repo->get_colegio_session_token() );
        });
    }

    public function get_clases()
    {
        return $this->clases_by_colegio_session()->get();
    }

    public function create( $fields )
    {
        \DB::beginTransaction();
        try
        {
            $horario_clase = $this->horarios_clases->create($fields);
            event( new \HorarioClaseWasCreated( $horario_clase, $fields ) );
            \DB::commit();
            return [ 'error' => false, 'data' => array( 'horario_clase' => $horario_clase ) ];
        }
        catch ( \QueryException $e)
        {
            \DB::rollBack();
            return [ 'error' => true, 'message' => $this->error_repo->getErrorByCode( $e->getCode() ) ];
        }
    }

    public function update( \HorarioClase $horario_clase, $fields )
    {
        \DB::beginTransaction();
        try
        {
            $horario_clase->update($fields);
            event( new \HorarioClaseWasUpdated( $horario_clase, $fields ) );
            \DB::commit();
            return [ 'error' => false, 'data' => array( 'horario_clase' => $horario_clase ) ];
        }
        catch ( \QueryException $e)
        {
            \DB::rollBack();
            return [ 'error' => true, 'message' => $this->error_repo->getErrorByCode( $e->getCode() ) ];
        }
    }

    public function delete( \HorarioClase $horario_clase )
    {
        \DB::beginTransaction();
        try
        {
            event(new \HorarioClaseWasDeleted( $horario_clase ));
            $horario_clase->delete();
            \DB::commit();
            return [ 'error' => false ];
        }
        catch ( \Illuminate\Database\QueryException $e)
        {
            \DB::rollBack();
            return [ 'error' => true, 'message' => $this->error_repo->getErrorByCode( $e->getCode() ) ];
        }
    }

    public function query_get_secciones_list()
    {
        return $this->custom_seccion_repo->query_get_secciones()
                                    //->whereDoesntHave('horario_clase')
                                    ->with
                                    ([
                                        'grado' => function( $grado_q )
                                        {
                                            $grado_q->orderBy('orden')->select('id', 'nombre', 'orden', 'categoria_id');
                                        },
                                        'grado.categoria:id,nombre,colegio_id'
                                    ])
                                    ->select('id', 'nombre', 'grado_id');
    }

    public function query_get_secciones_from_horarios_clases_from_responsable_id( $responsable_id = null )
    {
        return $this->custom_seccion_repo->secciones
        ->whereHas('horarios_clases')
        ->whereHas('susripciones.responsable', function( $responsable_q ) use ($responsable_id)
        {
            $responsable_q->where('id', $responsable_id);
        })
        ->with('grado:id,nombre');
    }

    public function query_get_horarios_clases_from_seccion_id( $seccion_id )
    {
        return $this->horarios_clases->where('seccion_id', $seccion_id);
    }

}