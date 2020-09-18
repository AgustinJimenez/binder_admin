<?php namespace Modules\Responsables\Repositories;

class SuscripcionesRepository
{

    public function update_from_responsable( $fields )
    {
       if( !isset( $fields['responsable_id'], $fields['secciones_ids'], $fields['device_info']['token'], $fields['device_info']) )
        return ['error' => true, 'message' => 'Ocurrio un error al intentar actualizar las suscripciones a grados.', 'debug-message' => $fields];

        $device_already_registered = \DispositivoRegistrado::where('token', $fields['device_info']['token'])->exists();

        $suscripciones_actuales = \ResponsableSuscripcionSeccion::where('responsable_id', $fields['responsable_id'])->get();
        foreach($suscripciones_actuales as $suscripcion)
            if( !in_array($suscripcion->id,  $fields['secciones_ids']) )
                $suscripcion->delete();//por cada suscripcion que tenga el usuario ira eliminando aquellas que no esten entre las nuevas suscripciones a realizar.
            else
                unset( $fields['secciones_ids'][array_search($suscripcion->id, $fields['secciones_ids'])] );//por cada suscripcion del usuario si esta ya esta entre las nuevas suscripciones 
                //entonces quiere decir que estaria duplicandose por lo tanto se elimina de entre las nuevas suscripciones

        foreach($fields['secciones_ids'] as $seccion_id)
        {
            if( !$device_already_registered )
                $device_registered = \DispositivoRegistrado::create
                ([
                    'token' => $fields['device_info']['token'],
                    'details' => $fields['device_info']
                ]);
            else
                $device_registered = \DispositivoRegistrado::where('token', $fields['device_info']['token'])->first();
            
            \ResponsableSuscripcionSeccion::create//crea nuevas suscripciones
            ([
                'responsable_id' => $fields['responsable_id'],
                'seccion_id' => $seccion_id,
                'dispositivo_token' => $device_registered->token
            ]);
            
        }       
                
        return ['error' => false];
    }

}
