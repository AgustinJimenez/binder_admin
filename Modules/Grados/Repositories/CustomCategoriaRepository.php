<?php namespace Modules\Grados\Repositories;

class CustomCategoriaRepository
{
	public function get_secciones_by_categoria_id($id)
	{
		return 
		\Seccion::whereHas(
		'grado.categoria', function ( $grado_categoria_query ) use ($id)
		{
		    $grado_categoria_query->where('id', $id);
		})
		->with
		([
			'grado' => function( $grado_query )
			{
				$grado_query->select('id', 'categoria_id');
			},
			'grado.categoria' => function( $grado_categoria_query )
			{
				$grado_categoria_query->select('id');
			}
		])
		->select('id', 'grado_id');
	}

	public function query_get_categorias_from_secciones_ids( $secciones_ids )
    {

		return \Categoria::with(['grados' => function($grados_q) use ($secciones_ids)
				{
					$grados_q->with(['secciones' => function($secciones_q) use ($secciones_ids)
					{
						$secciones_q->whereIn( 'id', $secciones_ids )->select('id', 'nombre', 'grado_id');
					}])
					->whereHas('secciones', function($secciones_q) use ($secciones_ids)
					{
						$secciones_q->whereIn( 'id', $secciones_ids );
					})
					->select('id', 'nombre', 'orden', 'categoria_id');
				}])
				->whereHas('grados', function($grados_q) use ($secciones_ids)
				{
					$grados_q->whereHas('secciones', function($secciones_q) use ($secciones_ids)
					{
						$secciones_q->whereIn( 'id', $secciones_ids );
					});
				});
		
		}


		public function queryGetCategoriasByColegioId( $params )
		{
			return \Categoria::where('colegio_id', $params['colegio_id']);
		}

		public function getCategoriasGradosSeccionesByColegioId( $params )
		{
			return $this->queryGetCategoriasByColegioId( $params )
					->select('id', 'nombre', 'colegio_id')
					->with
					([
						'grados' => function( $grados_q )
						{
							$grados_q->select('id', 'nombre', 'orden', 'categoria_id')
							->orderBy('orden', 'ASC')
							->with
							([
								'secciones' => function( $seccion_q )
								{
									$seccion_q->select('id', 'nombre', 'grado_id');
								}
							]);
						}
					])
					->get();
		}
}
