<?php namespace Modules\Horarios\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;

class HorarioClase extends Model 
{
    use  MediaRelation;
    protected $table = 'horarios__clases';
    protected $appends = ['imagen', 'seccion_grado_nombre', 'imagen_url'];
    protected $hidden = ['created_at', 'updated_at', 'imagen', 'seccion', 'seccion_id'];
    protected $fillable = [
        'seccion_id'
    ];
    
    public function seccion() 
    {
        return $this->belongsTo( \Seccion::class, 'seccion_id');
    }
    
    public function getSeccionGradoNombreAttribute()
    {
        return $this->seccion->grado->nombre . ' ' . $this->seccion->nombre;
    }

    public function getImagenAttribute()
    {
        return $this->filesByZone('imagen')->first();
    }

    public function getImagenUrlAttribute()
    {
        return ($this->imagen)?$this->imagen->path_string:null;
    }

    public function getEditRouteAttribute()
    {
        return route('admin.horarios.horarioclase.edit', [$this->id]);
    }

    public function getDeleteRouteAttribute()
    {
        return route('admin.horarios.horarioclase.destroy', [$this->id]);
    }



}
