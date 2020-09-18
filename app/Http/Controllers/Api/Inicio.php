<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Inicio extends Controller
{
    private $repo_inicio;

    public function __construct( \ApiInicioRepository $repo_inicio )
    {
        $this->repo_inicio = $repo_inicio;
    }

    public function get_inicio( Request $re )
    {
        return $this->repo_inicio->get_inicio_datas( $re );
    }

}   