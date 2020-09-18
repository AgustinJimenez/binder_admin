<?php

namespace Modules\Noticias\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class NoticiasDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker::create();
        Model::unguard();

        $min_col_id = \Colegio::min('id');
        $max_col_id = \Colegio::max('id');
        // $this->call("OthersTableSeeder");
        for( $i=0; $i < 1000; $i++ )
            \Noticia::create
            ([
                'titulo' => $i . " - " . $faker->streetAddress,
                'contenido' => $faker->randomHtml(10,10),
                'fecha' => $faker->dateTime('now')->format('d/m/Y'),
                'colegio_id' => $faker->numberBetween( $min_col_id, $max_col_id )
            ]);
        

    }
}
