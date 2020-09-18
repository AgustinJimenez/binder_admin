<?php

namespace Modules\Responsables\Entities;

use Illuminate\Database\Eloquent\Model;

class ResponsableSuscripcionSeccion extends Model
{
    protected $table = 'responsable_suscripcion_seccion';
    protected $fillable = ['responsable_id', 'seccion_id', 'dispositivo_token'];

    public function responsable()
    {
        return $this->belongsTo( \Responsable::class, 'responsable_id');
    }

    public function seccion()
    {
        return $this->belongsTo( \Seccion::class, 'seccion_id');
    }

    public function dispositivo()
    {
        return $this->belongsTo( \DispositivoRegistrado::class, 'dispositivo_token', 'token');
    }

}
