<?php

namespace Modules\Grados\Entities;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

    protected $table = 'grados__categorias';
    protected $fillable = ['nombre', 'colegio_id'];

    public function colegio()
    {
        return $this->belongsTo( \Colegio::class, 'colegio_id', 'id');
    }

    public function grados()
    {
        return $this->hasMany( \Grado::class, 'categoria_id')->orderBy('orden');
    }

    public function secciones()
    {                                   //destiny       //through     //fk on grado  //fk on seccion //local key on categorias // local key on grados
        return $this->hasManyThrough( \Seccion::class, \Grado::class, 'categoria_id', 'grado_id', 'id', 'id' );
    }

}
