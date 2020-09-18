<?php

namespace Modules\Alumnos\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AlumnosDatabaseSeeder extends Seeder
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

        \DB::beginTransaction();
        try
        {
            if( \Colegio::count() and \Categoria::count() and \Grado::count() and \Seccion::count()  )
            {
                $this->random_generator = \Faker::create();
                $this->main(); 
            }
            \DB::commit();
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            \DB::rollBack();
            echo $e->getMessage();
        }
    }

    function main()
    {
        foreach (\Colegio::get() as $colegio) 
            foreach ($colegio->categorias as $categoria) 
                foreach ($categoria->grados as $grado) 
                    if( $grado->categoria->colegio->tiene_varias_secciones  )
                        foreach ($grado->secciones as $seccion) 
                            $this->seed_crear_alumnos($grado, $seccion);
                    else
                        $this->seed_crear_alumnos($grado);  
    }

    function seed_crear_alumnos($grado, $seccion = null)
    {
        $letras = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u');
        $admin_password_crypted = \User::first()->password;

        foreach ($letras as $letra)
        {
            $tmp_array = 
            [
                'nombre' => $this->random_generator->name,
                'apellido' => $this->random_generator->lastName . ' | ' . ($seccion ? $seccion->nombre : 'Seccion null | ' . $grado->nombre),
                'ci' => $this->random_generator->numberBetween($min = 300000, $max = 600000),
                'fecha_nacimiento' => $this->random_generator->date($format = 'Y-m-d', $max = 'now'),
                'grado_id' => $grado->id,
                'seccion_id' => ($seccion ? $seccion->id : null)
            ];

            $alumno = new \Alumno;
            $alumno->fill($tmp_array);

            $tmp_array = 
            [
                'email' => $this->random_generator->unique()->email,
                'password' => $admin_password_crypted,
                'first_name' => $alumno->nombre,
                'last_name' => $alumno->apellido,
                'colegio_id' => $alumno->grado->categoria->colegio->id
            ];

            $user = new \User;
            $user->fill($tmp_array);

            $alumno->save();
            $user->save();

            \DB::table('role_users')->insert
            ([
                'user_id' => $user->id,
                'role_id' => 5,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }


}
