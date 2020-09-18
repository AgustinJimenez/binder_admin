<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class Noticias extends Controller
{

    private $noticia_repo;
    private $noticia_api_repo;

    public function __construct(  \CustomNoticiaRepository $noticia_repo, \ApiNoticiaRepository $noticia_api_repo )
    {
        $this->noticia_repo = $noticia_repo;
        $this->noticia_api_repo = $noticia_api_repo;
    }

    public function get_noticia_index(Request $re )
    {
        return 
        [
            'error' => false,
            'data' => 
            [
                'noticias' => $this
                ->noticia_repo
                ->query_get_noticias_by_colegio_token( $re->colegio_token )
                ->skip( $re->skip?$re->skip:0 )
                ->take( 5 )
                ->get()
            ]
        ];
    }

    public function get_noticia_detalles(Request $re )
    {
        $validation_results = $this->noticia_api_repo->noticia_detalle_validate( $re );

        if( $validation_results['error'] )
            return $validation_results; 

        return 
        [
            'error' => false,
            'data' => 
            [
                'noticia' => \Noticia::find( $re->noticia_id )
            ]
        ];
    }

}