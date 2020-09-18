<?php

namespace Modules\Grados\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CategoriasDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Model::unguard();

        $letras = array('a', 'b', 'c', 'd', 'e', 'f', 'g');
        
        //por cada colegio
        foreach (\Colegio::get() as $colegio) 
        
            //crea varias categorias por cada colegio
            foreach ($letras as $categoria_letra)
                \Categoria::create
                ([
                    'nombre' => 'Categoria ' . $categoria_letra . ' | ' . $colegio->nombre,
                    'colegio_id' => $colegio->id
                ]);
        
    }

}

