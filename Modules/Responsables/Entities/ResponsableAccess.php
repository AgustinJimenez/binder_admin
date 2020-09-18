<?php

namespace Modules\Responsables\Entities;

use Illuminate\Database\Eloquent\Model;

class ResponsableAccess extends Model
{
    protected $primaryKey = 'token';
    public $incrementing = false;
    protected $table = 'responsable_access';
    protected $fillable = ['token', 'responsable_id', 'last_login_time', 'last_login_device_token'];
    protected $hidden = ['updated_at', 'created_at'];

    public function responsable()
    {
        return $this->belongsTo( \Responsable::class, 'responsable_id');
    }

    public function responsable_has_logged_with_device_token( $device_token )
    {
        $this->update
        ([
            'last_login_time' => date("Y-m-d H:i:s"),
            'last_login_device_token' => $device_token
        ]);
    }

}