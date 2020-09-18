<?php 
namespace App\Http\Repository;

class ErrorsRepository
{
	public function getErrorByCode( $error_code )
	{
		if( $error_code == '23000' )
            return "DATABASE ERROR 23000: el registro ya esta asociado a otros registros.";
        else if ( $error_code == '42S02' )
            return "DATABASE ERROR 42S02: no se encuentra una de las tablas en la base de datos.";
        else
            return "Ocurrio un error insesperado de base de datos.";
	}


}