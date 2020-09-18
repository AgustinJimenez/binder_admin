<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Registro extends Controller
{
    private $repo;
    private $responsable_repo;
    private $repo_grado;

    public function __construct(\ApiRegistroRepository $repo, \ResponsableRepository $responsable_repo, \GradoRepository $repo_grado)
    {
        $this->repo = $repo;
        $this->responsable_repo = $responsable_repo;
        $this->repo_grado = $repo_grado;
    }

    public function getRegistrar(Request $re)
    {
        $data = array();
        $data['grados'] = $this->repo_grado->getGradosByColegioToken($re['colegio_token']);

        if (count($data['grados'])) 
        {
            $data['error'] = false;
        } 
        else 
        {
            $data['error'] = true;
            $data['error_tag'] = 'no-results';
            $data['message'] = 'El colegio no tiene grados asignados.';
        }

        return $data;
    }

    public function postRegistrar(Request $re)
    {

        \DB::beginTransaction();
    
        $re['secciones_ids'] = json_decode($re['secciones_ids'], true);
        $re['device_info'] = json_decode($re['device_info'], true);

        $validation_result = $this->repo->validate_responsable_fields($re->all());

        if ($validation_result['error']) 
            return $validation_result;

        $registrar_result = $this->repo->store_usuario_responsable($re->all());

        if ($registrar_result['error']) {
            \DB::rollBack();
            return [ 'error' => true, "message" => $registrar_result['message'], "debug_message" => $registrar_result['debug_message'], 'extra' => $re->all() ];
        }

        //\DB::rollBack();
        \DB::commit();
        return [ "error" => false, "message" => "Registro realizado correctamente." ];
    }
}
