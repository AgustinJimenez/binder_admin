<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use DB;
class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $random_generator;
    public function run()
    {


        Model::unguard();
        //$this->call(SentinelGroupSeedTableSeeder::class);
        DB::beginTransaction();
        try
        {
            $this->go();
            DB::commit();
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            DB::rollBack();
            echo $e->getMessage();
        }
            
    }


    function go()
    {
        $this->random_generator = \Faker::create();
        
        if( !DB::table('roles')->whereIn('name', ['Administrador', 'Responsable', 'Alumno'])->count() )
        {
            DB::insert('insert into roles (id, slug, name) values (?, ?, ?)', [3, 'Administrador','Administrador']);
            DB::insert('insert into roles (id, slug, name) values (?, ?, ?)', [4, 'Responsable','Responsable']);
            DB::insert('insert into roles (id, slug, name) values (?, ?, ?)', [5, 'Alumno','Alumno']);
        }
        

        $min_id_colegio = \Colegio::min('id');
        $max_id_colegio = \Colegio::max('id');
        $admin_password_crypted = \User::first()->password;

        for ($i=0; $i < 50 ; $i++) 
        {
            $user = \User::create
            ([
                'email' => $this->random_generator->email,
                'password' => $admin_password_crypted,
                'first_name' => $this->random_generator->firstName,
                'last_name' => $this->random_generator->lastName,
                'colegio_id' => $this->random_generator->numberBetween($min_id_colegio, $max_id_colegio)
            ]);
            

            $role_id = $this->random_generator->numberBetween(3,5);
            DB::table('role_users')->insert
            ([
                'user_id' => $user->id,
                'role_id' => $role_id,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if($role_id == 4)//Responsable
            {
                \Responsable::create
                ([
                    'nombre' => $user->first_name,
                    'apellido' => $user->last_name,
                    'telefono' => (int)( '09' . $this->random_generator->numberBetween(10000000, 99999999) ),
                    'user_id' => $user->id,
                    'ci' => $this->random_generator->numberBetween(300000, 600000),
                ]);
            }
            /*
            else if($role_id == 5)//Alumno
            {
                \Alumno::create
                ([
                    'nombre' => $this->random_generator->name,
                    'apellido' => $this->random_generator->lastName . ' | ' . ($seccion ? $seccion->nombre : 'Seccion null | ' . $grado->nombre),
                    'ci' => $this->random_generator->numberBetween($min = 300000, $max = 600000),
                    'fecha_nacimiento' => $this->random_generator->date($format = 'Y-m-d', $max = 'now'),
                    'grado_id' => $grado->id,
                    'seccion_id' => ($seccion ? $seccion->id : null),
                    'user_id' => $user->id,
                ]); 
            }
            */

        }
    }


}
