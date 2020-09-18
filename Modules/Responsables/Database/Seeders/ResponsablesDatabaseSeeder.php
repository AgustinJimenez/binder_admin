<?php

namespace Modules\Responsables\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Roles\EloquentRole;

class ResponsablesDatabaseSeeder extends Seeder
{
    private $repo_responsable;
    public function __construct( \CustomUserResponsableRepository $repo_responsable) 
    { 
 
        $this->repo_responsable = $repo_responsable; 
    } 

    public function run()
    {
        $faker = \Faker::create();
        
        $secciones_ids = \Seccion::get()->pluck('id')->toArray();
        for ($i=0; $i < 10000; $i++) 
        {
            $fields = 
            [
                'nombre' => $faker->firstName,
                'apellido' => $faker->lastName,
                'telefono' => $faker->e164PhoneNumber, 
                'email' => $faker->unique()->email,
                'estado' => $faker->randomElement(['aprobado','pendiente','rechazado']),
                'tipo_encargado' => $faker->randomElement(['papa','mama','tutor']),
                'password' => '123',
                'password_confirmation' => '123',
                'colegio_id' => $faker->numberBetween( \Colegio::min('id'), \Colegio::max('id'))
            ];
            $fields['first_name'] = $fields['nombre'];
            $fields['last_name'] = $fields['apellido'];

            \DB::beginTransaction();
            try
            {
                $responsables[] = $this
                        ->repo_responsable
                        ->create_responsable_with_user_with_suscripciones
                        ( 
                            $fields,  
                            collect($secciones_ids)->random( 5 )
                        );
                \DB::commit();
            }
            catch (\Illuminate\Database\QueryException $e)
            {
                \DB::rollBack();
                dd( $e.getMessage() );
            }
        }
        //\DB::rollBack();
        
        dd($responsables);
        //Model::unguard();
        // $this->call("OthersTableSeeder");
    }

}
