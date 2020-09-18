<?php namespace Modules\Avisos\Repositories;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class CustomAvisoRepository
{
    private $categoria_repo;
    private $grado_repo;
    private $error_repo;
    private $colegio_repo;

    public function __construct( 
        \CustomCategoriaRepository $categoria_repo, 
        \ErrorsRepository $error_repo, 
        \CustomGradoRepository $grado_repo,
        \CustomColegioRepository $colegio_repo
    )
    {
        $this->categoria_repo = $categoria_repo;
        $this->error_repo = $error_repo;
        $this->grado_repo = $grado_repo;
        $this->colegio_repo = $colegio_repo;
    }

    public function get_avisos_by_tipo($tipo)
    {
        return \Aviso::where('tipo', $tipo);
    }

    public function query_get_categorias_from_aviso_id( $aviso_id )
    {
        return \Categoria::whereHas('grados.secciones.avisos', function( $avisos_q ) use ( $aviso_id )
                {
                    $avisos_q->where( (new \Aviso)->getTable() . '.id', $aviso_id);
                })
                ->with
                ([
                    'grados' => function( $grados_q ) use ( $aviso_id )
                    {
                        $grados_q->whereHas('secciones.avisos', function( $avisos_q ) use ( $aviso_id )
                        {
                            $avisos_q->where( (new \Aviso)->getTable() . '.id', $aviso_id);
                        });
                    },
                    'grados.secciones' => function( $secciones_q ) use ( $aviso_id )
                    {
                        $secciones_q->whereHas('avisos', function( $avisos_q ) use ( $aviso_id )
                        {
                            $avisos_q->where( (new \Aviso)->getTable() . '.id', $aviso_id);
                        });
                    }
                ]);
    }

    public function delete_many_avisos_by_ids( $ids )
    {
        \DB::beginTransaction();
        try
        {
            foreach (\Aviso::whereIn('id', $ids/*[1, 2, 3]*/)->get() as $key => $aviso)
            {
                event(new \AvisoWasDeleted( $aviso ));
                $aviso->delete();
            }
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            \DB::rollBack();
            return ['error' => true, 'message' => "Ocurrio un error al intentar eliminar los registros.", 'debug-message' => $this->error_repo->getErrorByCode( $e->getCode() ) ];
        }

        return ['error' => false, 'commit' =>  \DB::commit()];
    }

    public function get_aviso_responsables_ajax( Request $re )
    {
        \DB::statement( \DB::raw('set @rownum=0') );

        return $this->json_get_aviso_responsables(

                    $this->query_get_aviso_responsable( $re )
                    ->with(['user:id,email', 'vistos' => function( $vistos_q ) use ($re)
                    {
                        $vistos_q->where('aviso_id', $re->aviso_id);
                    }])
                    ->select(
                        \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                        'id',
                        'nombre',
                        'apellido',
                        'tipo_encargado',
                        'telefono',
                        'user_id',
                        'estado',
                        'ci'
                    ),

                    $re

                );
    }

    public function query_get_aviso_responsable( Request $re )
    {
        $responsable_query = \Responsable::whereHas('secciones.avisos', function( $avisos_q ) use ($re)
                                {
                                    $avisos_q->where( (new \Aviso)->getTable() . '.id', $re->aviso_id );
                                });

        if( $re->filled('leido') )
            if( $re->leido == 'si' )
                $responsable_query->whereHas('vistos', function( $vistos_q ) use ($re)
                {
                    $vistos_q->where('aviso_id', $re->aviso_id);
                });
            else
                $responsable_query->whereDoesntHave('vistos', function( $vistos_q ) use ($re)
                {
                    $vistos_q->where('aviso_id', $re->aviso_id);
                });

        if( $re->filled('nombre_apellido') )
            $responsable_query->where(function ($q) use ($re)
                                    {
                                        $q->where('nombre', 'like', '%' . $re->nombre_apellido . '%' )
                                        ->orWhere('apellido', 'like', '%' . $re->nombre_apellido . '%');
                                    });

        if( $re->filled('estado') )
            $responsable_query->where('estado', $re->estado);

        if( $re->filled('seccion_id') and $re->filled('grado_id') and $re->filled('categoria_id') )
            $responsable_query->whereHas('secciones', function( $seccion_q ) use ( $re )
            {
                $seccion_q->where( (new \Seccion)->getTable() . '.id', $re->seccion_id );
            });
        else if( $re->filled('grado_id') and $re->filled('categoria_id') )
            $responsable_query->whereHas('secciones.grado', function( $grado_q ) use ( $re )
            {
                $grado_q->where((new \Grado)->getTable() . '.id', $re->grado_id );
            });
        else if( $re->filled('categoria_id') )
            $responsable_query->whereHas('secciones.grado.categoria', function( $categoria_q ) use ( $re )
            {
                $categoria_q->where((new \Categoria)->getTable() . '.id', $re->categoria_id );
            });

        return $responsable_query;

    }

    public function json_get_aviso_responsables( $query, Request $re )
    {
        $object = Datatables::of( $query )
        ->addColumn('visto', function ($row) use ( $re )
        {

            return $row->vistos->count() ? "SI" : "NO";
        })
        ->setRowClass( function ($tabla)
        {
            return "text-center";
        })
        //->rawColumns(['checkbox','ver_detalle_btn', 'enviado_recibido'])
        ->make(true);
        $data = $object->getData(true);
        //$data['debug-message'] = $re->all();
        return response()->json( $data );
    }

    public function get_avisos_ajax_by_colegio_token( Request $re )
    {
        return $this->get_avisos_ajax( $this->query_get_avisos_by_colegio_token( $re )->select('id','titulo', 'colegio_id', 'created_at'), $re );
    }

    public function query_get_avisos_by_colegio_token( Request $re )
    {
        $query_avisos =  \Aviso::
        whereHas('colegio', function($colegio_query) use ($re)
        {
            if( $re->filled('colegio_token') )
                $colegio_query->where('token', $re->colegio_token );
        })
        ->whereHas('secciones', function( $secciones_q ) use ($re)
        {
            if( $re->filled('seccion_id'))
                $secciones_q->where( (new \Seccion)->getTable() . '.id', $re->seccion_id);
        })
        ->whereHas('secciones.grado', function( $grados_q ) use ($re)
        {
            if( $re->filled('grado_id') and !$re->filled('seccion_id')  )
                $grados_q->where( (new \Grado)->getTable() . '.id', $re->grado_id);
        })
        ->whereHas('secciones.grado.categoria', function( $categorias_q ) use ($re)
        {
            if( $re->filled('categoria_id') and !$re->filled('grado_id') and !$re->filled('seccion_id')  )
                $categorias_q->where( (new \Categoria)->getTable() . '.id', $re->categoria_id );
        });

        if( $re->filled('titulo') )
            $query_avisos->where('titulo', 'like', '%' . $titulo . '%');

        if( $re->filled('fecha_desde') )
            $query_avisos->whereDate('created_at', '>=', \Carbon::createFromFormat('d/m/Y', $re->fecha_desde )->format('Y-m-d') );

        if( $re->filled('fecha_hasta') )
            $query_avisos->whereDate('created_at', '<=', \Carbon::createFromFormat('d/m/Y', $re->fecha_hasta )->format('Y-m-d') );

            Log::info('fecha '.\Carbon::createFromFormat('d/m/Y', $re->fecha_hasta )->format('Y-m-d'));

        return $query_avisos;

    }

    public function get_avisos_ajax( $query, Request $re )
    {
        $object = Datatables::of( $query )
        ->addColumn('checkbox', function ($row)
        {
            return $row->input_checkbox;
        })
        ->addColumn('ver_detalle_btn', function ($row)
        {
            return '<button class="btn btn-primary ver-detalle" aviso="' . $row->id . '">DETALLES</button>';
        })
        ->addColumn('enviado_recibido', function ($row)
        {
            return $row->button_enviado_recibido;
        })
        ->setRowClass( function ($tabla)
        {
            return "text-center";
        })
        ->rawColumns(['checkbox','ver_detalle_btn', 'enviado_recibido'])
        ->make(true);
        $data = $object->getData(true);
        //$data['debug-message'] = $re->all();
        return response()->json( $data );
    }

    public function create_aviso_procedure( $fields )
    {
        $validations_results = $this->create_validations($fields);
        if( $validations_results['error'] )
            return $validations_results;

        \DB::beginTransaction();
        try
        {
            $create_results  = $this->create( $fields );
            if( $create_results['error'] )
            {
                \DB::rollBack();
                return $create_results;
            }

        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return ['error' => true, 'message' => $this->error_repo->getErrorByCode( $e->getCode() ), 'rollback' => \DB::rollBack() ];
        }

        return [ 'error' => false, 'commit' =>  \DB::commit() ];
    }


    public function create_validations($fields)
    {
        $fields_are_valids =
        (
            isset
            (
                $fields['titulo'],
                $fields['fecha'],
                $fields['contenido'],
                $fields['firma'],
                $fields['tipo']
            )
            and
            (
                ($fields['tipo'] == 'general') or
                (
                    isset($fields['categorias_ids']) or
                    isset($fields['grados_ids']) or
                    isset($fields['secciones_ids'])
                )
            )
        );

        $has_selected  =
        ( $fields['tipo'] == 'por_categoria' or $fields['tipo'] == 'por_grado' or $fields['tipo'] == 'por_seccion' )?
        (
            array_search( '1', isset($fields['categorias_ids'])?$fields['categorias_ids']:[] ) or
            array_search( '1', isset($fields['grados_ids'])?$fields['grados_ids']:[] ) or
            array_search( '1', isset($fields['secciones_ids'])?$fields['secciones_ids']:[] )
        ):true;

        $rules =
        [
            'invalid-fields' => ( !$fields_are_valids ),
            'has-not-selected' => (!$has_selected)
        ];

        $messages =
        [
            'invalid-fields' => 'No se enviaron los datos necesarios.',
            'has-not-selected' => ($fields['tipo'] == 'por_categoria')?"No se selecciono ninguna categoria":(($fields['tipo'] == 'por_grado')?"No se selecciono ningun grado":(($fields['tipo'] == 'por_seccion')?"No se selecciono ninguna seccion":"No se selecciono ningun filtro"))
        ];

        if( $rules['invalid-fields'] )
            return ['error' => true, 'message' => $messages['invalid-fields'] ];
        if( $rules['has-not-selected'] )
            return ['error' => true, 'message' => $messages['has-not-selected'] ];

        return ['error' => false ];
    }


    public function create( $fields )
    {
        $aviso = \Aviso::create
        ([
            'titulo' => $fields['titulo'],
            'fecha' => $fields['fecha'],
            'contenido' => $fields['contenido'],
            'firma' => $fields['firma'],
            'tipo' => $fields['tipo'],
            'colegio_id' => \Helper::getSessionColegio()->id
        ]);

        $aviso_secciones = [];


        if( $aviso->tipo == 'por_categoria' and isset($fields['categorias_ids']) )
        {
            foreach ( $fields['categorias_ids'] as $categoria_id => $is_used )
                if( (int)$is_used )
                    foreach ($this->categoria_repo->get_secciones_by_categoria_id( $categoria_id )->select('id')->get() as $seccion)
                        $aviso_secciones[] = \AvisoSeccion::create([
                            'aviso_id' => $aviso->id,
                            'seccion_id' => $seccion->id
                        ]);
        }
        else if( $aviso->tipo == 'por_grado' and isset($fields['grados_ids']) )
        {
            foreach ( $fields['grados_ids'] as $grado_id => $is_used )
                if( (int)$is_used )
                    foreach ($this->grado_repo->get_secciones_by_grado_id( $grado_id )->select('id')->get() as $seccion)
                        $aviso_secciones[] = \AvisoSeccion::create([
                            'aviso_id' => $aviso->id,
                            'seccion_id' => $seccion->id
                        ]);
        }
        else if( $aviso->tipo == 'por_seccion' and isset($fields['secciones_ids']) )
        {
            foreach ( $fields['secciones_ids'] as $seccion_id => $is_used )
                if( (int)$is_used )
                    $aviso_secciones[] = \AvisoSeccion::create([
                        'aviso_id' => $aviso->id,
                        'seccion_id' => $seccion_id
                    ]);
        }
        else
        {
            foreach( 
            \Seccion::whereHas('grado.categoria.colegio', function( $colegio_q ){$colegio_q->where('token', $this->colegio_repo->get_colegio_session_token() );})->select('id')->get() as $key => $seccion )
                $aviso_secciones[] = \AvisoSeccion::create([
                    'aviso_id' => $aviso->id,
                    'seccion_id' => $seccion->id
                ]);
        }


        event( new \AvisoWasCreated( $aviso, $fields ) );

        return ['error' => false];
    }

    public function queryGetAvisosNoLeidosByResponsableId( $responsable_id )
    {
        return \Aviso::whereHas('relaciones_secciones.seccion.susripciones.responsable', function( $responsable_q ) use ($responsable_id)
        {
            $responsable_q->where('id', $responsable_id );
        })
        ->with(['relaciones_secciones' => function( $rs_q ) use ($responsable_id)
        {
            $rs_q->whereHas('seccion.susripciones.responsable', function( $responsable_q ) use ($responsable_id)
            {
                $responsable_q->where('id', $responsable_id );
            })
            ->select('id', 'aviso_id', 'seccion_id');
        }])
        ->whereDoesntHave('vistos');
    }

    public function queryGetAvisosByResponsableIdAndSeccionId( $params )
    {
        $avisos_q = \Aviso::whereHas('relaciones_secciones.seccion', function( $seccion_q ) use ($params)
        {
            $seccion_q->whereHas('susripciones.responsable', function( $responsable_q ) use ($params)
            {
                $responsable_q->where('id', $params['responsable_id']);
            });

            if( count($params['secciones_ids']) )
                $seccion_q->whereIn('seccion_id', $params['secciones_ids']);
        })
        ->with
        ([
            'relaciones_secciones' => function( $relaciones_secciones_q ) use ($params)
            {
                $relaciones_secciones_q->whereHas('seccion.susripciones.responsable', function( $responsable_q ) use ($params)
                {
                    $responsable_q->where('id', $params['responsable_id']);
                });

                if( count($params['secciones_ids']) )
                    $relaciones_secciones_q->whereHas('seccion', function( $seccion_q ) use ($params)
                    {
                        $seccion_q->whereIn('seccion_id', $params['secciones_ids']);
                    });
                    
                $relaciones_secciones_q->select('id', 'aviso_id', 'seccion_id');
            },
            'vistos' => function ( $vistos_q ) use ($params)
            {
                $vistos_q->where('responsable_id', $params['responsable_id']);
            }
        ])
        ->select('id', 'titulo', 'fecha', 'tipo', 'colegio_id')
        ->orderBy('created_at', 'DESC');

        if( isset( $params['skip'] ) )
            $avisos_q
            ->skip( ($params['skip']>0)?$params['skip']:0 )
            ->take( 5 );

        return ['error' => false, 'data' => array('avisos' => $avisos_q) ];
    }

    public function validateApiGetAvisoParams( $params )
    {
        $params['responsable_id'] = isset($params['responsable_id'])?$params['responsable_id']:null;
        $params['aviso_id'] = isset($params['aviso_id'])?$params['aviso_id']:null;

        $rules =
        [
            'invalid-fields' =>
            (
                !$params or
                !isset( $params['responsable_id'] ) or
                !isset( $params['aviso_id'] )
            ),

            'responsable-not-exist' => !\Responsable::where( 'id', $params['responsable_id'] )->exists(),

            'aviso-not-exist' => !\Aviso::where( 'id', $params['aviso_id'] )->exists(),

        ];

        $messages =
        [
            'invalid-fields' => 'Error, datos enviados invalidos o faltantes.',
            'responsable-not-exist' => 'El responsable no existe en el sistema.',
            'aviso-not-exist' => 'El aviso solicitado no existe en el sistema.'
        ];

        foreach( $rules as $key => $rule )
            if( $rule )
                return ['error' => true, 'message' => $messages[ $key ], 'debug-message' => $params ];

        return ['error' => false, 'debug-message' => $params ];
    }

    public function queryGetAvisoById( $params )
    {
        return  [
                    'error' => false, 'data' =>
                                    array(
                                        'aviso' => \Aviso::where('id', $params['aviso_id'])
                                            ->with(['relaciones_secciones' => function($rs_q) use ($params)
                                            {
                                                if( isset($params['seccion_id']) )
                                                    $rs_q->where('seccion_id', $params['seccion_id']);

                                            }, 'relaciones_secciones.seccion.grado' ])
                                        )];
    }
















}
