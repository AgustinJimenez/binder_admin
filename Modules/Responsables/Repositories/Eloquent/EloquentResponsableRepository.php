<?php

namespace Modules\Responsables\Repositories\Eloquent;

use Modules\Responsables\Repositories\ResponsableRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Cartalyst\Sentinel\Roles\EloquentRole;

class EloquentResponsableRepository extends EloquentBaseRepository implements ResponsableRepository
{
/*
    public function __construct( ) 
    { 
    } 
*/

    public function create_responsable_suscripciones( $responsable_id, $secciones_ids = [], $device_info = [] )
    {
        if( !is_int($responsable_id) or $responsable_id <= 0 )
            return ['error' => true, 'message' => "Primer argumento invalido, en Modules/Responsables/Repositories/Eloquent/EloquentResponsableRepository.php."];
        if( !is_array($secciones_ids) or !count($secciones_ids) )
            return ['error' => true, 'message' => "Segundo argumento invalido, en Modules/Responsables/Repositories/Eloquent/EloquentResponsableRepository.php. " . $secciones_ids ];
        if( !is_array($device_info) or !count($device_info) )
            return ['error' => true, 'message' => "Terccer argumento invalido, en Modules/Responsables/Repositories/Eloquent/EloquentResponsableRepository.php. " . $secciones_ids ];
        
            $suscripciones = [];
            $device = [];
        try 
        {
            $device_token = $device_info['token'];
            unset($device_info['token']);

            if( !\DispositivoRegistrado::where('token', $device_token )->exists() )
                $device = \DispositivoRegistrado::create( ["token" => $device_token, "details" => json_encode($device_info)] );


            foreach ($secciones_ids as $seccion_id) 
                array_push
                ( 
                    $suscripciones , 

                    \ResponsableSuscripcionSeccion::create([ 
                        'responsable_id' => $responsable_id,
                        'seccion_id' => $seccion_id,
                        'dispositivo_token' => $device_token
                    ])
                );

        } 
        catch(\Illuminate\Database\QueryException $e)
        {
            return [ 'error' => true, 'message' => "Ocurrio un error insesperado de base de datos. ", 'debug_message' => $e->getMessage() ];
        }

        return ['error' => false, 'message' => '', 'suscripciones' => $suscripciones, 'device' => $device];
    }

    public function getDefaultRole()
    {
        $role = EloquentRole::where('name', 'Responsable')->first();

        if(!$role)
            dd("ERROR, CHECK getDefaultRole() AT Modules/Responsables/Repositories/Eloquent/EloquentResponsableRepository.php");

        return $role->id;
    }

    public function processUserData($attributes, $create = false)
    {
        $data = [];
        foreach ($attributes as $key => $value)
        {
            if ($key === 'nombre')
                $data['first_name'] = $value;
            if ($key === 'apellido')
                $data['last_name'] = $value;
            if ($key === 'email')
                $data[$key] = $value;
            if ($key === 'password')
                $data[$key] = $value;
        }

        if ($create)
        {
            $data['roles'] = $this->getDefaultRole();
            return \Helper::addColegioIdRequest($data, $attributes['colegio_token']);
        }
        else
        {
            $data['activated'] = true;
            return $data;
        }
    }

    public function validate_for_notification_if_aprobado($responsable, $params)
    {
        
        return 
        ( 
            isset($params['options']) and 

            isset($params['options']['notificate_if_aprobado']) and 

            $params['options']['notificate_if_aprobado'] and 

            ($responsable['estado'] != 'aprobado') and 

            ($params['responsable']['estado'] == 'aprobado')

        );

    }

    public function create_responsable_access( $responsable_id )
    {
        while ( \ResponsableAccess::where('token', $token = str_random( 16 ))->exists() ){}

        return \ResponsableAccess::create
        ([
            'responsable_id' => $responsable_id,
            'token' => $token
        ]);

    }

}
