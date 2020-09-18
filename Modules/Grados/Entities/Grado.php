<?php

namespace Modules\Grados\Entities;

use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{

    protected $table = 'grados__grados';
    public $translatedAttributes = [];
    protected $fillable = ['nombre', 'categoria_id', 'orden'];


    public function categoria()
    {
        return $this->belongsTo( \Categoria::class, 'categoria_id');
    }

    public function secciones()
    {
        return $this->hasMany( \Seccion::class, 'grado_id');
    }

    public function withHref($attribute)
    {
        $edit = route('admin.grados.grado.edit', [$this->id]);
        $td = "<a href='".$edit." '>".$attribute."</a>";
        return $td;
    }
}
