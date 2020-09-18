<?php

namespace Modules\Responsables\Repositories; 
class ForgotPasswordRepository
{
	public function save( $fields )
	{
		\DB::beginTransaction();
		try
		{
			$token = str_random(16);
	        while( \ForgotPassword::where('token', $token)->exists() )
	            $token = str_random(16);

	        return [ 
	        		'error' => false, 
	        		'data' => 
        				[
	        				'forgot_password' => 
	        				\ForgotPassword::create([ 
					            'email' => $fields['email'], 
					            'dispositivo_token' => $fields['token'], 
					            'expiration_date' => \Carbon::now()->addDay(),//24 hours
					            'token' => $token
					        ]),
    						'commited' => 
    						//\DB::rollBack()
    						\DB::commit()
    					],
	        		];
		}
		catch (\Illuminate\Database\QueryException $e)
		{	
			\DB::rollBack();
			return [ 'error' => true, 'message' => 'Ocurrio un error al procesar el pedido', 'debug_message' => $e->getMessage() ];
		}
        
	}
}
