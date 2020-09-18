<?php

namespace Modules\Responsables\Entities;

use Illuminate\Database\Eloquent\Model;

class DispositivoRegistrado extends Model
{
    protected $table = 'dispositivos_registrados';
    protected $fillable = ['token', 'details'];
    protected $primaryKey = 'token';
    public $incrementing = false;

    public function access()
    {
        return $this->hasMany( \ResponsableAccess::class, 'last_login_device_token', 'token');
    }

    public function getDetailsAttribute()
    {
        return json_decode( $this->attributes['details'] );
    }

    

}
