<?php

namespace Modules\Avisos\Entities;

use Illuminate\Database\Eloquent\Model;

class AvisoSeccion extends Model
{
    protected $table = 'avisos__relacion__secciones';
    protected $fillable = 
    [
    	'aviso_id',
        'seccion_id'
    ];
       
    public function seccion()
    {
        return $this->belongsTo( \Seccion::class, 'seccion_id' );
    }

    public function aviso()
    {
        return $this->belongsTo( \Aviso::class, 'aviso_id' );
    }

}