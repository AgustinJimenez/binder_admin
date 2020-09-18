<?php namespace Modules\Grados\Repositories;

class CustomSeccionRepository
{
	public $secciones;
	public function __construct( \Seccion $secciones )
    {
        $this->secciones = $secciones;
    }

	public function query_get_secciones( $colegio_token = null )
	{

		return \Seccion::whereHas("grado.categoria.colegio", function( $colegio_q ) use ($colegio_token)
		{
			if( !$colegio_token and session()->get('colegio_token') )
				$colegio_token = session()->get('colegio_token');

			if( $colegio_token )
				$colegio_q->where('token', $colegio_token );
		});
	}

	public function query_get_secciones_list()
    {
        return $this->query_get_secciones()
                                    //->whereDoesntHave('horario_clase')
                                    ->with
                                    ([
                                        'grado' => function( $grado_q )
                                        {
                                            $grado_q->orderBy('orden')->select('id', 'nombre', 'orden', 'categoria_id');
                                        },
                                        'grado.categoria:id,nombre,colegio_id'
                                    ])
                                    ->select('id', 'nombre', 'grado_id');
    }

	public function queryGetSeccionesByColegioId( $params )
	{
		return \Seccion::whereHas('grado', function($grado_q) use($params)
				{
					$grado_q->whereHas('categoria', function($categoria_q) use($params)
					{
						$categoria_q->where('colegio_id', $params['colegio_id']);
					});
				});
	}
	//retorna todas las secciones a las que esta suscrito el responsable con avisos que contengan vistos que pertenezcan al responsable
	public function queryGetSeccionesSuscripcionesByResponsableId( $fields )
	{								//obtener todas las secciones a las que el responsable este suscrito
		return $this->secciones->whereHas('susripciones.responsable', function( $responsable_q ) use ($fields)
			{
				$responsable_q->where('id', $fields['responsable_id']);
			})
			->with
			([
				'grado' => function($grado_q)
				{
					$grado_q->select('id', 'nombre');
				},
				//con los avisos de esa seccion
				'avisos' => function($avisos_q) use ($fields)
				{
					$avisos_q//con los vistos de esos avisos
					->with(['vistos' => function($vistos_q) use ($fields)
					{
						$vistos_q//vistos que pertenezcan al responsable
						->where('responsable_id', $fields['responsable_id']);
					}])
					->whereHas('colegio', function( $colegio_q ) use ($fields)
					{
						$colegio_q->where('token', $fields['colegio_token']);
					})
					->select( (new \Aviso)->getTable() . '.id');
				}
			])
			->select('id', 'nombre', 'grado_id');
	}

	public function QueryGetSeccionById( $id )
	{
		return \Seccion::where('id', $id);
	}

}
