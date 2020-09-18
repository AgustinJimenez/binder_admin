<?php namespace App\Http\Repository\Api;

use Illuminate\Http\Request;

class ApiInicioRepository
{
    private $noticia_repo;
    private $aviso_repo;

    public function __construct( \CustomNoticiaRepository $noticia_repo , \CustomAvisoRepository $aviso_repo )
    {
        $this->noticia_repo = $noticia_repo;
        $this->aviso_repo = $aviso_repo;
    }

    public function get_inicio_datas( Request $re )
    {  
        $avisos_no_leidos = $this->aviso_repo->queryGetAvisosNoLeidosByResponsableId( $re->responsable_id )
        ->orderBy('created_at', 'DESC')
        ->select('id', 'titulo', 'fecha', 'colegio_id');

            $avisos_no_leidos
            ->skip( $re->skip ? $re->skip : 0 )
            ->take( 5 );
        
        $data = 
        [
            'error' => false,
            'data' => 
            [
                'last_noticia' => ($last_noticia = $this->noticia_repo->getLastNoticiaByResponsableId( $re->responsable_id, ['id', 'titulo', 'fecha', 'colegio_id']))?$last_noticia->toArray():$last_noticia,
                'avisos_no_leidos' => ($avisos_no_leidos = $avisos_no_leidos->get())?$avisos_no_leidos->toArray():$avisos_no_leidos
                
            ],
            'debug-message' => $re->all()
        ];

        return $data;
    }




}