<?php

namespace Modules\Alumnos\Entities;

use Illuminate\Database\Eloquent\Model;

class Relacion extends Model
{

    protected $table = 'alumnos__relacions';
    public $translatedAttributes = [];
    protected $fillable = ['alumno_id', 'responsable_id'];

    public function alumno()
    {
        return $this->belongsTo('Modules\Alumnos\Entities\Alumno', 'alumno_id', 'id');
    }

    public function responsable()
    {
        return $this->belongsTo('Modules\Responsables\Entities\Responsable', 'responsable_id', 'id');
    }
}
