<?php namespace Modules\Horarios\Repositories;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;

class CustomHorarioExamenRepository
{
    public $error_repo;
    public $custom_seccion_repo;
    public $custom_colegio_repo;
    public $horarios_examenes;

    public function __construct
    ( 
        \HorarioExamen $horarios_examenes, 
        \ErrorsRepository $error_repo, 
        \CustomSeccionRepository $custom_seccion_repo, 
        \CustomColegioRepository $custom_colegio_repo
    )
    {
        $this->error_repo = $error_repo;
        $this->custom_seccion_repo = $custom_seccion_repo;
        $this->custom_colegio_repo = $custom_colegio_repo;
        $this->horarios_examenes = $horarios_examenes;
    }

    public function query_get_horarios_examenes_from_seccion_id( $seccion_id )
    {
        return $this->horarios_examenes->where('seccion_id', $seccion_id);
    }

    public function query_index_horarios_examenes()
    {
        return $this->horarios_examenes->whereHas('seccion.grado.categoria.colegio', function( $colegio_q )
        {
            $colegio_q->where('token', $this->custom_colegio_repo->get_colegio_session_token() );
        });
    }

    public function get_secciones_list()
    {
        return $this->custom_seccion_repo->query_get_secciones_list();
    }

    public function query_get_horarios_examenes( Request $re )
    { 
        $query = $this->query_index_horarios_examenes();
   
        if( $re->filled('fecha_inicio') )
            $query->where('fecha', '>=', \Carbon::createFromFormat( 'd/m/Y', $re->get('fecha_inicio') )->format('Y-m-d') );

        if( $re->filled('fecha_fin') )
            $query->where('fecha', '<=', \Carbon::createFromFormat( 'd/m/Y', $re->get('fecha_fin') )->format('Y-m-d') );

        if( $re->filled('materia') )
            $query->where('materia', 'like', '%' . $re->get('materia') . '%' );
/*
        dd(
            $query->get()->toArray()
        );
*/
        return $query;
    }

    public function create( $fields )
    {
        \DB::beginTransaction();
        try
        {
            $horario_examen = \HorarioExamen::create($fields);
            //event( new \HorarioClaseWasCreated( $horario_examen, $fields ) );
            \DB::commit();
            return [ 'error' => false, 'data' => array( 'horario_examen' => $horario_examen ) ];
        }
        catch ( \QueryException $e)
        {
            \DB::rollBack();
            return [ 'error' => true, 'message' => $this->error_repo->getErrorByCode( $e->getCode() ) ];
        }
    }

    public function get_horarios_examenes_ajax( $query = null )
    {
        if( !$query )
            return 'no query found';

        $object = Datatables::of( $query )
        ->addColumn('acciones', function($row)
        {
            return '<div class="btn-group">

                        <a class="btn btn-flat btn-primary" href="' . $row->edit_route . '"> 
                            <i class="fa fa-pencil"></i> 
                        </a>

                        <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modal-delete-confirmation" data-action-target="' . $row->delete_route . '">
                            <i class="fa fa-trash"></i>
                        </button>

                    </div>';
        })
        ->setRowClass( function ($row) 
        { 
            return "text-center"; 
        })
        ->rawColumns(['acciones'])
        ->make(true);
        $data = $object->getData(true);
        return response()->json( $data );
    }


    public function query_get_secciones_from_horarios_examenes_from_responsable_id( $responsable_id = null )
    {
        return $this->custom_seccion_repo->secciones
        ->whereHas('horarios_examenes')
        ->whereHas('susripciones.responsable', function( $responsable_q ) use ($responsable_id)
        {
            $responsable_q->where('id', $responsable_id);
        })
        ->with('grado:id,nombre');
        
    }

















}