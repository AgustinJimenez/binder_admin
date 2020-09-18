<?php

namespace Modules\Alumnos\Entities;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{

    protected $table = 'alumnos__alumnos';
    public $translatedAttributes = [];
    protected $fillable = ['nombre', 'apellido', 'ci', 'fecha_nacimiento', 'grado_id', 'seccion_id', 'user_id'];

    public function grado()
    {
        return $this->belongsTo('Modules\Grados\Entities\Grado', 'grado_id', 'id');
    }

    public function seccion()
    {
        return $this->belongsTo('Modules\Grados\Entities\Seccion', 'seccion_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\User::class, 'user_id');
    }

    public function relaciones()
    {
        return $this->hasMany('Modules\Alumnos\Entities\Relacion', 'alumno_id', 'id');
    }
    

	public function getFechaNacimientoAttribute()
	{
		return \Helper::dateFrom($this->attributes['fecha_nacimiento']);
	}

    public function withHref($attribute)
    {
        $edit = route('admin.alumnos.alumno.edit', [$this->id]);
        $td = "<a href='".$edit." '>".$attribute."</a>";
        return $td;
    }
}