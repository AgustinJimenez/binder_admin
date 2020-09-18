<?php namespace Modules\Horarios\Entities;

use Illuminate\Database\Eloquent\Model;

class HorarioExamen extends Model
{
    protected $table = 'horarios__examenes';
    protected $appends = ['seccion_grado_nombre'];
    protected $hidden = ['seccion', 'seccion_id', 'created_at', 'updated_at'];
    protected $fillable = 
    [
        'seccion_id',
        'fecha',
        'materia',
        'contenido'
    ];

    public function seccion() 
    {
        return $this->belongsTo( \Seccion::class, 'seccion_id');
    }

    public function getEditRouteAttribute()
    {
        return route('admin.horarios.horarioexamen.edit', [$this->id]);
    }

    public function getDeleteRouteAttribute()
    {
        return route('admin.horarios.horarioexamen.destroy', [$this->id]);
    }

    public function getSeccionGradoNombreAttribute()
    {
        return $this->seccion->grado->nombre . ' ' . $this->seccion->nombre;
    }


    public function setFechaAttribute( $value )
    {
        $this->attributes['fecha'] = \Carbon::createFromFormat('d/m/Y', $value);
    }

    public function getFechaAttribute()
    {
        if( !is_string( $this->attributes['fecha'] ) and get_class( $this->attributes['fecha'] ) == "Illuminate\Support\Carbon" )
            return $this->attributes['fecha']->format('d/m/Y');
        else
            return ( isset($this->attributes['fecha']) ) ? \Carbon::createFromFormat('Y-m-d', $this->attributes['fecha'])->format('d/m/Y') : '' ;
    }

}
