<?php

namespace Modules\Grados\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SeccionesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $letras = array('a', 'b', 'c');
        
        //por cada grado
        foreach (\Grado::get() as $grado) 
            //crea varias secciones por cada grado
            foreach ($letras as $seccion_letra)
                \Seccion::create
                ([
                    'nombre' => 'Seccion ' . $seccion_letra . ' | ' . $grado->nombre,
                    'grado_id' => $grado->id
                ]);
            
    }

}