<?php

namespace Modules\Grados\Entities;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{

    protected $table = 'grados__seccions';
    public $translatedAttributes = [];
    protected $fillable = ['nombre', 'grado_id'];
    protected $appends = ['nombre_grado', 'nombre_grado_seccion'];

    public function grado()
    {
        return $this->belongsTo( \Grado::class, 'grado_id', 'id');
    }

    public function horarios_clases()
    {
        return $this->hasMany( \HorarioClase::class, 'seccion_id' );
    }

    public function horarios_examenes()
    {
        return $this->hasMany( \HorarioExamen::class, 'seccion_id' );
    }

    public function susripciones()
    {
        return $this->hasMany( \ResponsableSuscripcionSeccion::class, 'seccion_id' );
    }

    public function responsables()
    {
        return $this->belongsToMany( \Responsable::class, (new \ResponsableSuscripcionSeccion)->getTable(), 'seccion_id', 'responsable_id' );
    }

    public function avisos()
    {
        return $this->belongsToMany( \Aviso::class, (new \AvisoSeccion)->getTable(), 'seccion_id', 'aviso_id' );
    }

    public function relacion_avisos()
    {
        return $this->hasMany( \AvisoSeccion::class, "seccion_id" );
    }

    public function getNombreGradoAttribute()
    {
        return $this->grado->nombre;
    }

    public function getNombreGradoSeccionAttribute()
    {
        return $this->grado->nombre . ' ' . $this->nombre;
    }

    public function withHref($attribute)
    {
        $edit = route('admin.grados.seccion.edit', [$this->id]);
        $td = "<a href='".$edit." '>".$attribute."</a>";
        return $td;
    }

    public function getGradoSeccionNombresAttribute()
    {
        return ['grado' => $this->grado->nombre, 'seccion' => $this->nombre];
    }
}
