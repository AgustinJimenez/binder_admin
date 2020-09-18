<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeleccionColegio extends Controller
{
    private $custom_colegio_repo;

    public function __construct( \CustomColegioRepository $custom_colegio_repo )
    {
        $this->custom_colegio_repo = $custom_colegio_repo;
    }

    public function search_colegio(Request $re)
    {
        $colegios = $this->custom_colegio_repo
                    ->query_search_colegios_by_name( $re->nombre )
                    ->orderBy('nombre')
                    ->take(5)
                    ->get(['id', 'nombre', 'token']);
                    //->toArray();

        return ['error' => false, 'data' => array('colegios' => $colegios) ];
    }


}