<?php

namespace Modules\Grados\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class GradosGradosDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $letras = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h');
        
        //por cada categoria
        foreach (\Categoria::get() as $categoria) 
        
            //crea varios grados por cada categoria
            foreach ($letras as $grado_letra)
                \Grado::create
                ([
                    'nombre' => 'Grado ' . $grado_letra . ' | ' . $categoria->nombre,
                    'categoria_id' => $categoria->id
                ]);
    }

}