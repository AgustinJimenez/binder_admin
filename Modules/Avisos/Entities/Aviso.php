<?php

namespace Modules\Avisos\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;

class Aviso extends Model
{
	use  MediaRelation;
    protected $table = 'avisos__avisos';
    protected $fillable = 
    [
    	'titulo',
		'fecha',
		'contenido',
		'firma',
        'tipo',
        'colegio_id'
    ];
    protected $appends = ['archivo'];
    //protected $hidden = ['archivo'];
       
    public function colegio()
    {
        return $this->belongsTo( \Colegio::class, 'colegio_id' );
    }

    public function secciones()
    {
        return $this->belongsToMany( \Seccion::class, (new \AvisoSeccion)->getTable(), 'aviso_id', 'seccion_id' );
    }

    public function relaciones_secciones()
    {
        return $this->hasMany( \AvisoSeccion::class, 'aviso_id' );
    }

    public function vistos()
    {
        return $this->hasMany( \Visto::class, 'aviso_id' );
    }

    public function vistos_route( $categoria_id, $grado_id, $seccion_id )
    {
        return route('admin.avisos.aviso.vistos', [$this->id, $categoria_id, $grado_id, $seccion_id]);
    }

    public function getButtonEnviadoRecibidoAttribute()
    {
        return '<a class="btn btn-primary btn-sm button-enviado-recibido" href="' . $this->vistos_route('', '', '') . '"><b> ' . $this->enviado_recibido . ' </b></a>';
    }

    public function getEnviadoRecibidoAttribute()
    {
        return $this->cantidad_suscriptos . '/' . $this->vistos()->count();
    }
    public function getCantidadSuscriptosAttribute()
    {
        return $this->query_get_responsables_suscriptos->count();
    }

    public function getQueryGetResponsablesSuscriptosAttribute()
    {
        return \Responsable::whereHas('secciones.avisos', function( $avisos_q )
                {
                    $avisos_q->where( (new \Aviso)->getTable() . '.id', $this->id);
                });
                /*
                ->with(['secciones' => function( $seccion_q )
                {
                    $seccion_q->select( (new \Seccion)->getTable() . '.id')
                    ->whereHas('avisos', function( $avisos_q )
                    {
                        $avisos_q->where( (new \Aviso)->getTable() . '.id', $this->id);
                    })
                    ->with(['avisos' => function( $avisos_q )
                    {
                        $avisos_q->select( (new \Aviso)->getTable() . '.id', 'titulo' )
                        ->where( (new \Aviso)->getTable() . '.id', $this->id);
                    }]);
                }])
                */
               // ->select( (new \Responsable)->getTable() . '.id', 'nombre', 'apellido');
                //->take(5)
                //->get()
                //->toArray()
    }

    public function getSeccionesIdsAttribute()
    {
        return $this->relaciones_secciones->pluck('seccion_id')->toArray();
    }

    public function setFechaAttribute( $value )
    {
        $this->attributes['fecha'] = \Carbon::createFromFormat('d/m/Y', $value);
    }

    public function getFechaAttribute()
    {
        return isset($this->attributes['fecha']) ? \Carbon::createFromFormat('Y-m-d', $this->attributes['fecha'])->format('d/m/Y') : '' ;
    }
    public function getCreatedAtAttribute()
    {
        return isset($this->attributes['created_at']) ? \Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->format('d/m/Y') : '' ;
    }
    public function getArchivoAttribute()
    {
        return $this->filesByZone('archivo')->first();
    }
    
    public function getTipoFormatedAttribute()
    {
        return ($this->tipo == 'general') ? "General" : 
        (
            ($this->tipo == 'por_categoria') ? "Por Categoria":
            (
                ($this->tipo == 'por_grado') ? "Por Grado":
                (
                    ($this->tipo == 'por_seccion')?"Por Seccion":"Invalido"
                )
            )
        );
    }

    public function getInputCheckboxAttribute()
    {
        $javascript_event_onclick = 
        "
        var aria_checked = $(this).attr('aria-checked');
        var checkbox_value = $(this).find('input[type=checkbox]').val();
        $(this)
        .toggleClass('checked')
        .attr('aria-checked', (aria_checked == 'false')?'true':'false' )
        .find('input[type=checkbox]')
        .val( (checkbox_value == '0')?'1':'0' );";
        
        
        return '<div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;" onclick="'.$javascript_event_onclick.'">
                    <input type="checkbox" style="position: absolute; opacity: 0;" name="aviso[' . $this->id . ']" value="0">
                    <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                    </ins>
                </div>';
    }

}
