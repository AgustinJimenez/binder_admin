<?php 
namespace App\Http\Repository;

class NotificationsRepository
{
    public function __construct()
    {
    }

    public function new_push_notification($type = 'fcm')
    {
        return new \Edujugon\PushNotification\PushNotification($type);
    }

    public function responsable_was_aprobado( $title = null, $message = null, $device_token = null )
    {
        if( !$message )
            return [ 'error' => true, 'message' => 'No message provided.'];
        else if( !$device_token and !\DispositivoRegistrado::where("token", $device_token)->exists() )
            return [ 'error' => true, 'message' => 'Invalid user token.'];

        $push = $this->new_push_notification();
        $push->setMessage
        ([
            'notification' => 
            [
                'title'=> $title,
                'body'=> $message,
                'sound' => 'default'
            ]
        ])
        ->setDevicesToken($device_token)
        ->send();
        
        return [ 'error' => false , 'message' => ''];
    }

    


}