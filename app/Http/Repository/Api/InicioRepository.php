<?php namespace App\Http\Repository\Api;

use Illuminate\Http\Request;

class InicioRepository
{
    private $noticia_repo;
    private $aviso_repo;

    public function __construct( \CustomNoticiaRepository $noticia_repo, \CustomNoticiaRepository $aviso_repo )
    {
        $this->noticia_repo = $noticia_repo;
        $this->aviso_repo = $aviso_repo;
    }

    public function get_inicio_datas( Request $re )
    {
        return 
        [
            'last_noticia' => $this->noticia_repo->query_get_noticias_by_colegio_token( $re->colegio_token )->first()->toArray(),
            'avisos' => $this->aviso_repo->query_get_noticias_by_colegio_token( $re->colegio_token )->get()->toArray()
        ];
    }





} 