<?php namespace Modules\Responsables\Repositories;

use Illuminate\Http\Request;

class CustomDispositivoRepository
{

    private $dispositivos;
    private $error_repo;

    public function __construct( \DispositivoRegistrado $dispositivos, \ErrorsRepository $error_repo )
    {
        $this->dispositivos = $dispositivos;
        $this->error_repo = $error_repo;
    }

    public function exists( $token = null )
    {
        return $this->dispositivos->where('token', $token)->exists();
    }

    public function create($token = null, $device_info = [])
    {
        return $this->dispositivos->create
        ([
            'token' => $token,
            'details' => json_encode( $device_info )
        ]);
    }

    public function update($token = null, $device_info = [])
    {
        return $this->dispositivos->where('token', $token)->update
        ([
            'details' => json_encode( $device_info )
        ]);
    }

    public function find($token = null)
    {
        return $this->dispositivos->find($token);
    }

    public function create_if_not_exists( $token, $device_info )
    {
        return ($device = $this->find( $token )) ? $device : $this->create( $token, $device_info ) ;
    }

    public function update_or_create( $token = null, $device_info = [] )
    {
        \DB::beginTransaction();
        try
        {

            if( !$this->exists( $token ) )
                $this->create($token, $device_info);
            else
                $this->update( $token, $device_info );

            \DB::commit();
            return ['error' => false];
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            \DB::rollBack();
            return ['error' => true, 'message' => 'Ocurrio un error al tratar de registrar/actualizar al dispositivo en el sistema', 'debug-message' => $this->error_repo->getErrorByCode( $e->getCode() ) ];
        }
    }

}