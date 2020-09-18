<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Avisos extends Controller
{
    private $aviso_repo;
    private $seccion_repo;
    private $visto_repo;

    public function __construct( 
                    \CustomAvisoRepository $aviso_repo, 
                    \CustomSeccionRepository $seccion_repo,
                    \CustomVistoRepository $visto_repo
                    )
    {
        $this->aviso_repo = $aviso_repo;
        $this->seccion_repo = $seccion_repo;
        $this->visto_repo = $visto_repo;
    }

    public function index(Request $re)
    {
        $re['secciones_ids'] = json_decode( $re->secciones_ids, true);

        $results = $this
        ->aviso_repo
        ->queryGetAvisosByResponsableIdAndSeccionId
        ([ 
            'responsable_id' => $re->responsable_id, 
            'secciones_ids' => $re->secciones_ids, 
            'skip' => (int)$re->skip
        ]);

        if( $results['error'] )
            return $results;
/*
dd(
    $results['data']['avisos']->get()->toArray()
);
*/
        return 
            [ 
                'error' => false , 
                'data' => 
                    ['avisos' => $results['data']['avisos']->get()->toArray() ],
                'debug-message' => $re->all() 
            ];
    }

    public function get_aviso(Request $re)
    {
        $validation_results = $this->aviso_repo->validateApiGetAvisoParams( $re->all() );

        if( $validation_results['error'] )
            return $validation_results;


        $aviso_results = $this->aviso_repo->queryGetAvisoById([ 'aviso_id' => $re->aviso_id ]);

        if( $aviso_results['error'] )
            return $aviso_results;
/*
        $seccion = $this->seccion_repo->QueryGetSeccionById( $re->seccion_id );
*/
        $aviso = $aviso_results['data']['aviso']
        ->with
        ([
            'vistos' => function( $vistos_q ) use ($re)
            {
                $vistos_q->where('responsable_id', $re->responsable_id);
            },
            'relaciones_secciones' => function( $rs_q ) use ($re)
            {
                $rs_q->where('seccion_id', $re->seccion_id);
            }
            
        ])
        ->select('id', 'titulo', 'fecha', 'contenido', 'firma', 'tipo')
        ->first()
        ->toArray();

        if( isset($aviso['archivo']) and isset( $aviso['archivo']['path_string'] ) )
            $aviso['archivo'] = ['path_string' => $aviso['archivo']['path_string']];

        return 
        array
        ( 
            'error' => false , 
            'data' => 
            [
                'aviso' => $aviso
            ]
                
        );

    }

    public function post_create_visto(Request $re)
    {
        return $this->visto_repo->create( $re );
    }

}