<?php namespace Modules\Noticias\Repositories;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;

class CustomNoticiaRepository
{
    private $error_repo;
    private $noticias;

    public function __construct( \ErrorsRepository $error_repo, \Noticia $noticias )
    {
        $this->error_repo = $error_repo;
        $this->noticias = $noticias;
    }

    public function query_get_noticias_by_colegio_token( $colegio_token )
    {
        return \Noticia::where('colegio_id', \Colegio::where('token', $colegio_token)->select('id')->first()->id )->orderBy('fecha', 'DESC');
    }

    public function queryGetNoticiasByResponsableId( $responsable_id )
    {
        return $this
                ->noticias
                ->where
                (
                    'colegio_id', 
                    \Responsable::find($responsable_id)->user->colegio->id
                );
    }

    public function getLastNoticiaByResponsableId( $responsable_id, $columns = ['*'] )
    {
        return $this
                ->queryGetNoticiasByResponsableId( $responsable_id )
                ->orderBy('fecha', 'DESC')
                ->select($columns)
                ->first();
    }

    public function get_noticias_ajax_by_colegio_token( Request $re )
    {   
        return $this->get_noticias_ajax( $re, $this->noticias->where('colegio_id', \Colegio::where('token', $re->colegio_token)->select('id')->first()->id ) );
    }

    

    public function get_noticias_ajax( Request $request, $query = null  )
    {
        if( $request->fecha_inicio and $request->has('fecha_inicio') and  trim( $request->get('fecha_inicio') !== '' ) )
            $query->where('fecha', '>=', \Carbon::createFromFormat( 'd/m/Y', $request->get('fecha_inicio') )->format('Y-m-d') );

        if( $request->fecha_fin and $request->has('fecha_fin') and $request->get('fecha_fin') != '' )
            $query->where('fecha', '<=', \Carbon::createFromFormat( 'd/m/Y', $request->get('fecha_fin') )->format('Y-m-d') );

        if( $request->has('titulo') and $request->get('titulo') != ''  )
            $query->where('titulo', 'like', '%' . $request['titulo'] . '%' );

        $object = Datatables::of( $query )
        ->addColumn('acciones', function ($row)
        {
            return '<div class="btn-group">
                        <button class="btn btn-flat btn-primary btn-noticia-detalles" registro="' . $row->id . '"> DETALLES </button>
                        <a class="btn btn-flat btn-primary" href="' . $row->edit_route . '"> EDITAR </a>
                        <button class="btn btn-flat btn-danger btn-noticia-eliminar" registro="' . $row->id . '"> <i class="fa fa-trash"></i> </button>
                    </div>
                    ';
        })
        ->setRowClass( function ($tabla) 
        { 
            return "text-center"; 
        })
        ->rawColumns(['acciones'])
        ->make(true);
        $data = $object->getData(true);
        return response()->json( $data );
    }

    public function create( $fields )
    {
        \DB::beginTransaction();
        try
        {
            $noticia = \Noticia::create
            ([
                'titulo' => $fields['titulo'],
                'fecha' => $fields['fecha'],
                'contenido' => $fields['contenido'],
                'colegio_id' => \Helper::getSessionColegio()->id
            ]);
            event( new \NoticiaWasCreated( $noticia, $fields ) );
            
            \DB::commit();
            return ['error' => false];
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            \DB::rollBack();
            return ['error' => true, 'message' => $this->error_repo->getErrorByCode( $e->getCode() ) ];
        }
    }

    public function update( \Noticia $noticia, $fields )
    {
        \DB::beginTransaction();
        try
        {
            $noticia->update( $fields );
            event( new \NoticiaWasUpdated( $noticia, $fields ) );
            \DB::commit();
            return ['error' => false];
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            \DB::rollBack();
            return ['error' => true, 'message' => $this->error_repo->getErrorByCode( $e->getCode() ) ];
        }
    }

    public function create_procedure( Request $fields, $validate = true )
    {
        if( $validate )
        {
            $validations_results = $this->create_validations($fields);
            if( $validations_results['error'] )
                return $validations_results;
        }
        
        return  $this->create( $fields );    
    }

    public function delete( \Noticia $noticia )
    {
        \DB::beginTransaction();
        try
        {
            event(new \NoticiaWasDeleted( $noticia ));
            $noticia->delete();
            \DB::commit();
            return ['error' => false];
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            \DB::rollBack();
            return ['error' => true, 'message' => $this->error_repo->getErrorByCode( $e->getCode() ) ];
        }
    }

    

    public function create_validations( Request $request )
    {

        $rules = 
        [
            'invalid-fields' => 
            ( 
                !$request->has('titulo') or
                !$request->has('fecha') or
                !$request->has('contenido')
            )

        ];

        $messages = 
        [
            'invalid-fields' => 'Error, datos enviados invalidos o faltantes.'
        ];

        foreach( $rules as $key => $rule )
            if( $rule )
                return ['error' => true, 'message' => $messages[ $key ], 'debug-message' => $params ];

        return ['error' => false, 'debug-message' => $params ];

    }

    

}
