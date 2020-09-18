<?php 

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Colegios\Entities\Colegio;
use Modules\Grados\Entities\Categoria;
use Modules\Grados\Entities\Grado;
use Modules\Grados\Entities\Seccion;
use Carbon\Carbon;
//use Laracasts\Flash\Flash;

class Helper
{
	public static function dateTo($date)
	{
		return date('Y-m-d', strtotime(str_replace('/', '-', $date)));
	}

	public static function dateFrom($date)
	{
		if ($date !== '0000-00-00')
		  return Carbon::parse($date)->format('d/m/Y');
		else
		  return '';
	}

	public static function getUserColegioId( $colegio_token = null )
	{
		
		if (  ( !session()->has('colegio_token') or !\Colegio::where('token', session()->get('colegio_token') )->exists() ) and !$colegio_token )
		{
			$last_error = 'Debe establecer un colegio para proceder.';
			session(compact('last_error'));
			//flash()->error($last_error);

			abort(403, $last_error);
		}
		
		$colegio_token = ($colegio_token) ? $colegio_token : session()->get('colegio_token') ;

		$colegio = Colegio::where('token', $colegio_token )->first();

		return $colegio->id;
	}

	public static function addColegioIdRequest($attributes, $colegio_token = null )
	{
		$attributes = $attributes + ['colegio_id' => self::getUserColegioId($colegio_token)];
		return $attributes;
	}

	public static function getSessionColegio()
	{
		return Colegio::where('token', session()->get('colegio_token'))->first();
	}

	public static function getSessionColegioName()
	{
		$colegio = self::getSessionColegio();
		return $colegio->nombre;
	}

	public static function colegioTieneVariasSecciones()
	{
		$colegio = self::getSessionColegio();
		return $colegio->tiene_varias_secciones;
	}

	public static function addDefaultOptionArray($array = [])
	{
		return [null => '---'] + $array;
	}

	public static function getTableButtons($edit, $destroy, $append = '')
    {
		return 
		"<div class='btn-group'>
			<a href='". $edit." ' class='btn btn-default btn-flat'>
				<i class='glyphicon glyphicon-pencil'></i>
			</a>
			<button class='btn btn-danger btn-flat' data-toggle='modal' data-target='#modal-delete-confirmation' data-action-target='". $destroy ."'>
				<i class='glyphicon glyphicon-trash'></i>
			</button>
			". $append ."
        </div>";
    }

    public static function isValidOption($value, $options)
    {
    	if (is_numeric($value))
    		$value = (int) $value;
    	
    	return array_key_exists($value, $options);
    }

    public static function getCategorias()
    {
    	return Categoria::where('colegio_id', self::getUserColegioId())
                                ->orderBy('nombre')->get()->pluck('nombre', 'id')->toArray();
    }

    public static function getGrados()
    {
    	return Grado::orderBy('nombre')->whereHas('categoria', function($q)
                {
                    $q->where('colegio_id', self::getUserColegioId());
				})
				->orderBy('orden')
				->get()
				->pluck('nombre', 'id')
				->toArray();
    }

    public static function getSecciones()
    {
    	return Seccion::whereHas('grado', function($query)
                {
                    $query->whereHas('categoria', function($q)
                    {
                        $q->where('colegio_id', self::getUserColegioId());
                    });
                })->orderBy('nombre')->get()->pluck('nombre', 'id')->toArray();
	}
	
	public static function getTipoEncargado()
	{
		return ['papa', 'mama', 'tutor'];
	}
}