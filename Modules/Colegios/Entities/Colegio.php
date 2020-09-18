<?php

namespace Modules\Colegios\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
class Colegio extends Model
{
    use  MediaRelation;
    protected $table = 'colegios__colegios';
    protected $appends = ['imagen', 'imagen_url'];
    protected $fillable = ['nombre', 'token', 'tiene_varias_secciones'];
    protected $hidden = ['imagen'];


    public function categorias()
    {
        return $this->hasMany(\Categoria::class, 'colegio_id');
    }

    public function usuarios()
    {
        return $this->hasMany( \User::class, 'colegio_id' );
    }

    public function getImagenAttribute()
    {
        return $this->filesByZone('imagen')->first();
    }

    public function getImagenUrlAttribute()
    {
        return $this->get_imagen_url();
    }

    public function get_imagen_url()
    {
        return ( $this->imagen ) ? $this->imagen->path_string : null ;
    }

    
}
