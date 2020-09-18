<?php

namespace Modules\Responsables\Entities;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{

    protected $table = 'responsables__responsables';
    protected $fillable = ['nombre', 'apellido', 'telefono', 'user_id', 'ci', 'tipo_encargado', 'estado'];

    public function user()
    {
        return $this->belongsTo('Modules\User\Entities\Sentinel\User', 'user_id', 'id');
    }

    public function vistos()
    {
        return $this->hasMany( \Visto::class, 'responsable_id' );
    }

    public function access()
    {
        return $this->hasOne( \ResponsableAccess::class, 'responsable_id' );
    }

    public function has_visto_aviso( $aviso_id = null )
    {
        return \Visto::where('responsable_id', $this->id)->where('aviso_id', $aviso_id)->exists();
    }

    public function relaciones()
    {
        return $this->hasMany('Modules\Alumnos\Entities\Relacion', 'responsable_id', 'id');
    }

    public function suscripciones()
    {
        return $this->hasMany( \ResponsableSuscripcionSeccion::class, 'responsable_id');
    }

    public function secciones()
    {
        return $this->belongsToMany( \Seccion::class, (new \ResponsableSuscripcionSeccion)->getTable(), 'responsable_id', 'seccion_id' );
    }

    public function getSuscripcionesSeccionesIdsAttribute()
    {
        return $this->suscripciones()->select('seccion_id')->pluck('seccion_id')->ToArray();
    }

    public function getCategoriasGradosSeccionesSuscripcionesAttribute()
    {
        $suscripciones_secciones_ids = $this->suscripciones_secciones_ids;

        return \Categoria::
                whereHas('grados.secciones', function( $secciones_q ) use ($suscripciones_secciones_ids)
                {
                    $secciones_q->whereIn('id', $suscripciones_secciones_ids );
                })
                ->with(['grados' => function( $grados_q ) use ($suscripciones_secciones_ids)
                {
                    $grados_q->with(['secciones' => function( $secciones_q ) use ($suscripciones_secciones_ids)
                    {
                        $secciones_q->select('id', 'nombre', 'grado_id')->whereIn('id', $suscripciones_secciones_ids );
                    }])
                    ->whereHas('secciones', function( $secciones_q ) use ($suscripciones_secciones_ids)
                    {
                        $secciones_q->whereIn('id', $suscripciones_secciones_ids );
                    })
                    ->select('id', 'nombre', 'orden', 'categoria_id')
                    ->orderBy('orden', 'ASC');
                }])
                ->select('id', 'nombre')
                ->get();
    }

    public function getNombreApellidoAttribute()
    {
        return $this->nombre . " " . $this->apellido;
    }

    public function getTipoEncargadoFormatedAttribute()
    {
        return ucfirst( $this->tipo_encargado ); 
    }

    public function grado_secciones_lista($merged = false)
    {
        $lista = [];
        foreach( $this->suscripciones as $suscripcion )
            if($merged)
                $lista[] = implode(' ', $suscripcion->seccion->grado_seccion_nombres);
            else
                $lista[] = $suscripcion->seccion->grado_seccion_nombres;
        return $lista;
    }

    public function withHref($attribute)
    {
        $edit = route('admin.responsables.responsable.edit', [$this->id]);
        $td = "<a href='".$edit." '>".$attribute."</a>";
        return $td;
    }

    public function getSubclassAttribute()
    {
        return ($this->estado == 'pendiente') ? 'btn-warning' : 
                (($this->estado == 'aprobado') ? 'btn-success' : 
                (($this->estado == 'rechazado') ? 'btn-danger' : 
                'btn-link')) ;
    }
}