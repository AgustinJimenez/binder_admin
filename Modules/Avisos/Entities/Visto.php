<?php

namespace Modules\Avisos\Entities;

use Illuminate\Database\Eloquent\Model;

class Visto extends Model
{
    
    protected $table = 'avisos_visto_responsables';
    protected $fillable = 
    [
        'aviso_id', 
        'responsable_id'
    ];
    protected $hidden = ['created_at', 'updated_at'];
    
    public function responsable()
    {
        return $this->belongsTo( \Responsable::class, 'responsable_id' );
    }

    public function aviso()
    {
        return $this->belongsTo( \Aviso::class, 'aviso_id' );
    }

}
