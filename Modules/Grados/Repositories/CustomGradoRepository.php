<?php namespace Modules\Grados\Repositories;

class CustomGradoRepository
{

    public function queryGetGradosByColegioId( $params )
    {
        return \Grado::whereHas('categoria', function( $categoria_q ) use($params)
        {
            $categoria_q->where('colegio_id', $params['colegio_id']);
        });
    }

    public function get_secciones_by_grado_id( $grado_id )
    {
        return \Seccion::whereHas('grado', function( $grado_q ) use ($grado_id)
        {
            $grado_q->where('id', $grado_id);
        });
    }

}
