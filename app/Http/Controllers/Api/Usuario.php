<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class Usuario extends Controller
{
    private $repo_api_user;
    private $repo_grado;

    public function __construct(  \ApiUsuarioRepository $repo_api_user, \GradoRepository $repo_grado )
    {
        $this->repo_api_user = $repo_api_user;
        $this->repo_grado = $repo_grado;
    }

    public function show(Request $re)
    {
        if( !isset($re->responsable_id) )
            return [ 'error' => true, 'message' => 'Datos invalidos.', 'debug-message' => $re->all() ];

        $responsable = $this->repo_api_user->get_perfil_usuario_api_show( $re->responsable_id );

        if( !$responsable )
            return ['error' => true, 'message' => "No se encuentra al responsable en el sistema.", 'debug-message' => $re->all() ];

        $responsable->tipo_encargado_formated = $responsable->tipo_encargado_formated;
        $responsable->grado_secciones_lista = implode(', ', $responsable->grado_secciones_lista(true) );
        
        unset($responsable['suscripciones']);
        if( !$responsable )
            return [ 'error' => true, 'message' => 'Datos no encontrados.', 'debug-message' => $re->all() ];

        return ['error' => false, 'message' => 'here usuario show', 'others' => ['responsable' => $responsable->toArray()] ];
    }

    public function edit(Request $re)
    {
        if( !isset($re->responsable_id) )
            return [ 'error' => true, 'message' => 'Datos invalidos.', 'debug-message' => $re->all() ];

        $responsable = $this->repo_api_user->get_perfil_usuario_api_edit( $re->responsable_id );

        if( !$responsable )
            return [ 'error' => true, 'message' => 'Datos no encontrados.', 'debug-message' => $re->all() ];

        $colegio_grados = $this->repo_grado->getGradosByColegioToken( $re->colegio_token );

        $colegio_grados = $this->repo_api_user->add_suscriptions_to_grados_sections($colegio_grados, $responsable);

        return ['error' => false, 'debug-message' => '', 'others' => ['responsable' => $responsable->toArray(), 'grados' => $colegio_grados, 'suscripciones_ids' => $responsable->suscripciones->pluck('seccion_id')->toArray()] ];
    }

    public function update(Request $re)
    {
        $re['secciones_ids'] = json_decode($re['secciones_ids'], true);
        $re['device_info'] = json_decode($re['device_info'], true);
        
        $update_results = $this->repo_api_user->update( $re->all() );

        if( $update_results['error'] )
            return $update_results; 

        return ['error' => false, 'debug-message' => $re->all()];
    }






}