<?php 
namespace App\Http\Repository\Api;

class ApiUsuarioRepository
{
    private $repo_user;
    private $repo_responsable;
    private $repo_suscripciones;

    public function __construct( \UserRepository $repo_user, \ResponsableRepository $repo_responsable, \SuscripcionesRepository $repo_suscripciones )
    {
        $this->repo_user = $repo_user;
        $this->repo_responsable = $repo_responsable;
        $this->repo_suscripciones = $repo_suscripciones;
    }

    public function get_perfil_usuario_api_show( $responsable_id )
    {
        return \Responsable::with
        ([
            'user' => function( $q )
            { 
                $q->select(['id', 'email']);
            }
        ])
        ->select(['id', 'nombre', 'apellido', 'telefono', 'user_id', 'tipo_encargado'])
        ->find( $responsable_id );
    }


    public function get_perfil_usuario_api_edit( $responsable_id )
    {
         
        return \Responsable::with
        ([
            'user' => function( $q )
            { 
                $q->select(['id', 'email']);
            },
            'suscripciones' => function( $suscripcion_query )
            {
                $suscripcion_query->select(['id', 'responsable_id', 'seccion_id']);
            }
        ])
        ->select(['id', 'nombre', 'apellido', 'telefono', 'user_id', 'tipo_encargado'])
        ->find( $responsable_id );
    }

    public function add_suscriptions_to_grados_sections($colegio_grados, $responsable)
    {
        $ids_secciones_suscritas = $responsable->suscripciones->pluck('seccion_id')->toArray();

        foreach($colegio_grados as $key => $grado)
            foreach($grado['secciones'] as $key2 => $seccion)
                $colegio_grados[$key]['secciones'][$key2]['suscrito'] = in_array( $seccion['id'], $ids_secciones_suscritas );

        return $colegio_grados;
    }

    public function update( $fields, $validate = true, $update_responsable_too = true)
    {
        \DB::beginTransaction();

        if( $validate )
        {
            $validation_results = $this->validate_update( $fields );
            if( $validation_results['error'] )
                return $validation_results;
        }
        
        $responsable = \Responsable::find($fields['responsable_id']);
        $before = $responsable->user;

        $this->repo_user->updateAndSyncRoles($responsable->user->id, $this->processUserData($fields), $this->getDefaultRole()); 
        $this->repo_responsable->update( $responsable, $fields );

        if( $update_responsable_too )
            $update_suscripciones_result = $this->repo_suscripciones->update_from_responsable( $fields );

        if( $update_responsable_too and $update_suscripciones_result['error'] )
        {
            \DB::rollBack();
            return $update_suscripciones_result;
        }
            


        //\DB::rollBack();
        \DB::commit();
        return [ 'error' => false, 'debug-message' => $fields ];
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
            return \Helper::addColegioIdRequest($data); 
        } 
        else 
        { 
            $data['activated'] = true; 
            return $data; 
        } 
    } 

    public function getDefaultRole() 
    { 
        $role = \EloquentRole::where('name', 'Responsable')->first(); 
 
        return $role->id; 
    } 

    public function validate_update( $fields )
    {
        $rules = 
        [
            'invalid-fields' => 
            ( 
                !$fields or 
                !isset
                ( 
                    $fields['nombre'], 
                    $fields['apellido'], 
                    $fields['email'], 
                    $fields['tipo_encargado'],
                    $fields['secciones_ids'],
                    $fields['telefono'], 
                    $fields['device_info'],
                    $fields['device_info']['token']
                )
            ),

            'email-already-exist' =>
            ( 
                \User::whereDoesntHave('responsable', function ($responsable_query) use ($fields)
                {
                    $responsable_query->where('id', $fields['responsable_id']);

                })->where( 'email', $fields['email'] )->exists() 
            )

        ];

        $messages = 
        [
            'invalid-fields' => 'Error, datos enviados invalidos o faltantes.',
            'email-already-exist' => 'El email ya existe en el sistema.',
        ];

        
        if( $rules['invalid-fields'] )
            return ['error' => true, 'message' => $messages['invalid-fields'], 'debug-message' => $fields ];

        if( $rules['email-already-exist'] )
            return ['error' => true, 'message' => $messages['email-already-exist'], 'debug-message' => $fields ];

        return ['error' => false ];
    }


}
