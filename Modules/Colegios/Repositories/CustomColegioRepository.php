<?php namespace Modules\Colegios\Repositories;

use Illuminate\Http\Request;

class CustomColegioRepository
{
    private $colegio;

    public function __construct( \Colegio $colegios )
    {
        $this->colegios = $colegios;
    }

    public function query_search_colegios_by_name( $nombre = null )
    {
        return $this->colegios->where('nombre', 'like', '%' . $nombre . '%');
    }

    public function get_colegio_session_token()
    {
        return session()->has('colegio_token')?session()->get('colegio_token'):null;
    }

    public function get_colegio_session()
    {
        return $this->colegios->where('token', $this->get_colegio_session_token() )->first();
    }

    public function get_colegio_logo( $token = null )
    {
        if( $colegio = $this->colegios->where("token", $token)->first(['token', 'id']) and $colegio->imagen )
            return $colegio->imagen->path_string;
        else
            return null;
    }

}