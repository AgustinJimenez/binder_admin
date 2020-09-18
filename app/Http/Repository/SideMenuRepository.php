<?php namespace App\Http\Repository;

use Illuminate\Http\Request;
class SideMenuRepository
{
    private $custom_horario_examen_repo;
    private $custom_horario_clase_repo;

    public function __construct( \CustomHorarioClaseRepository $custom_horario_clase_repo , \CustomHorarioExamenRepository $custom_horario_examen_repo )
    {
        $this->custom_horario_clase_repo = $custom_horario_clase_repo;
        $this->custom_horario_examen_repo = $custom_horario_examen_repo;
    }

    public function clean_side_menu_grados_data_to_send( &$secciones_suscritas )
    {
        foreach( $secciones_suscritas as $key_seccion =>  $seccion_suscrita)
            foreach( $seccion_suscrita['avisos'] as $key_aviso => $aviso )
            {
                unset( 
                    $secciones_suscritas[ $key_seccion ]['avisos'][ $key_aviso ]['archivo'], 
                    $secciones_suscritas[ $key_seccion ]['avisos'][ $key_aviso ]['pivot'] 
                );
                foreach( $aviso['vistos'] as $key_visto => $visto )
                    unset( $secciones_suscritas[ $key_seccion ]['avisos'][ $key_aviso ]['vistos'][$key_visto]['responsable_id'] );
            }
    }


    public function get_horarios_secciones($responsable_id = null)
    {
        return  
        [
            'secciones_horarios_examenes' => $this->custom_horario_examen_repo->query_get_secciones_from_horarios_examenes_from_responsable_id( $responsable_id )->select('id', 'nombre', 'grado_id')->get()->toArray(),

            'secciones_horarios_clases' => $this->custom_horario_clase_repo->query_get_secciones_from_horarios_clases_from_responsable_id( $responsable_id )->select('id', 'nombre', 'grado_id')->get()->toArray()
            
        ];
    }

}