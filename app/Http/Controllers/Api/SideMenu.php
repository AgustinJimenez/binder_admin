<?php namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repository\SideMenuRepository;

class SideMenu extends Controller
{
    private $repo;
    private $repo_secciones;

    public function __construct( SideMenuRepository $repo, \CustomSeccionRepository $repo_secciones )
    {
        $this->repo = $repo;
        $this->repo_secciones = $repo_secciones;
    }

    /*
    array:2 
        "colegio_token" 
        "responsable_id"
    */
    public function getSideMenuGrados(Request $re)
    {
        
        $secciones_suscritas = $this->repo_secciones->queryGetSeccionesSuscripcionesByResponsableId( $re->all() )->get()->toArray();

        $this->repo->clean_side_menu_grados_data_to_send( $secciones_suscritas );

        return 
        [ 
            'error' => false, 
            'data' => 
            [
                'horarios_secciones' => $this->repo->get_horarios_secciones( $re->responsable_id ),
                'secciones_suscritas' => $secciones_suscritas
                
            ] 
        ];
    }

}