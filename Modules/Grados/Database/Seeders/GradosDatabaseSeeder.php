<?php

namespace Modules\Grados\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class GradosDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if( \Colegio::count() )
        {
            $this->call(CategoriasDatabaseSeeder::class);
            $this->call(GradosGradosDatabaseSeeder::class);
            $this->call(SeccionesDatabaseSeeder::class);
        }

    }
}
