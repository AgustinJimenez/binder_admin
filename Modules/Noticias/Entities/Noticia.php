<?php namespace Modules\Noticias\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;

class Noticia extends Model
{
    use  MediaRelation;
    protected $table = 'noticias__noticias';
    protected $hidden = ['created_at', 'updated_at'/*, 'archivo'*/];
    protected $appends = ['archivo'];
    protected $fillable = 
    [
        'titulo',
        'fecha',
        'contenido',
        'colegio_id'
    ];

    public function colegio()
    {
        return $this->belongsTo( \Colegio::class, 'colegio_id' );
    }

    public function getFechaAttribute()
    {
        if( !is_string( $this->attributes['fecha'] ) and get_class( $this->attributes['fecha'] ) == "Illuminate\Support\Carbon" )
            return $this->attributes['fecha']->format('d/m/Y');
        else
            return ( isset($this->attributes['fecha']) ) ? \Carbon::createFromFormat('Y-m-d', $this->attributes['fecha'])->format('d/m/Y') : '' ;
    }
    public function setFechaAttribute( $value )
    {
        $this->attributes['fecha'] = \Carbon::createFromFormat('d/m/Y', $value);
    }
    public function getArchivoAttribute()
    {
        return $this->filesByZone('archivo')->first();
    }
    
    public function getEditRouteAttribute()
    {
        return route('admin.noticias.noticia.edit', [$this->id]);
    }


    
}
