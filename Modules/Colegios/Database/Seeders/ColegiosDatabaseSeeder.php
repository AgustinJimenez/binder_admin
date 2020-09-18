<?php

namespace Modules\Colegios\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
class ColegiosDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $generator = Faker::create();

        Model::unguard();

        $letras = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p' , 'q');

        foreach ($letras as $key => $letra) {

            $token = str_random(80);
             while ( \Colegio::where('token', $token)->exists() )
                $token = str_random(80);

                \Colegio::create(['nombre' => $generator->name,'token' => $token, 'tiene_varias_secciones' => $generator->boolean ]);

        }

        // $this->call("OthersTableSeeder");
    }
}
