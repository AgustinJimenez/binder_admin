<?php

namespace Modules\Grados\Repositories\Eloquent;

use Modules\Grados\Repositories\GradoRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentGradoRepository extends EloquentBaseRepository implements GradoRepository
{

    //params: string
    //return: array
    public function query_get_grados_by_colegio_token( $colegio_token = null )
    {
        if( !$colegio_token )
            $colegio_token = session()->get('colegio_token');

        return \Grado::whereHas("categoria", function($categoria_query) use ($colegio_token)
        {
            $categoria_query->whereHas('colegio', function($colegio_query) use ($colegio_token) 
            {
                $colegio_query->where('token', $colegio_token );
            });
        })
        ->with
        ([
            'categoria' => function( $categoria_query )
            {
                $categoria_query->select('id', 'nombre', 'colegio_id');
            },
            'categoria.colegio' => function( $colegio_query )
            {
                $colegio_query->select('token', 'nombre', 'tiene_varias_secciones');
            },
            'secciones' => function( $secciones_query )
            {
                $secciones_query->select('id', 'nombre', 'grado_id');
            }
        ])
        ->orderBy('orden');
    }

    public function getGradosByColegioToken( $colegio_token = null )
    {
        if( !$colegio_token )
            $colegio_token = session()->get('colegio_token');

        return \Grado::whereHas("categoria", function($categoria_query) use ($colegio_token)
        {
            $categoria_query->whereHas('colegio', function($colegio_query) use ($colegio_token) 
            {
                $colegio_query->where('token', $colegio_token );
            });
        })
        ->with
        ([
            'categoria' => function( $categoria_query )
            {
                $categoria_query->select('id', 'nombre', 'colegio_id');
            },
            'categoria.colegio' => function( $colegio_query )
            {
                $colegio_query->select('token', 'nombre', 'tiene_varias_secciones');
            },
            'secciones' => function( $secciones_query )
            {
                $secciones_query->select('id', 'nombre', 'grado_id');
            }
        ])
        ->select('id', 'nombre', 'categoria_id', 'orden')
        ->orderBy('orden')
        ->get()
        ->toArray();

    }

    public function getColegioGradosWithResponsableSuscription( $responsable_id )
    {
        return \Grado::whereHas("categoria", function($categoria_query) use ($responsable_id)
        {
            $categoria_query->whereHas('colegio', function($colegio_query) use ($responsable_id) 
            {
                $colegio_query->whereHas('usuarios', function ($usuarios_query) use ($responsable_id)
                {
                    $usuarios_query->whereHas('responsable', function ($responsable_query) use ($responsable_id)
                    {
                        $responsable_query->where('id', $responsable_id);
                    });
                });
            });
        })
        ->with
        ([
            'secciones' => function( $secciones_query )
            {
                $secciones_query->select('id', 'nombre', 'grado_id');
            }
        ])
        ->select('id', 'nombre', 'categoria_id', 'orden')
        ->orderBy('orden');
    }


}
