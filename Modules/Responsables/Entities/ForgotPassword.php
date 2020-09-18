<?php

namespace Modules\Responsables\Entities;

use Illuminate\Database\Eloquent\Model;

class ForgotPassword extends Model
{
    protected $fillable = ['token', 'dispositivo_token', 'email', 'expiration_date'];
    protected $table = 'responsable_forgot_password';
    protected $primaryKey = 'token';
    public $incrementing = false;
    protected $hidden = ['created_at', 'updated_at'];

    public function dispositivo()
    {
        return $this->belongsTo( \DispositivoRegistrado::class, 'dispositivo_token', 'token');
    }
    public function getExpiredAttribute()
    {
        return ( $this->expiration_date <= \Carbon::now() );
    }
    public function getExpirationDateAttribute()
    {
    	return \Carbon::createFromFormat( 'Y-m-d H:i:s', $this->attributes['expiration_date']  );
    }
}
