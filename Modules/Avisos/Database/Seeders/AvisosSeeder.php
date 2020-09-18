<?php

namespace Modules\Avisos\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AvisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $generator = \Faker::create();

        for ($i=0; $i < 100; $i++) 
        {
            \DB::beginTransaction();
            try
            {
                $aviso = \Aviso::create
                ([
                    'titulo' => 'Aviso Nro ' . $i,
                    'fecha' => $generator->date('d/m/Y', 'now'),
                    'contenido' => $generator->text,
                    'firma' => $generator->name,
                    'tipo' => 'por_seccion',
                    'colegio_id' => $generator->numberBetween( \Colegio::min('id'), \Colegio::max('id'))
                ]);

                $created_at = \Carbon::createFromFormat('d/m/Y', $aviso->created_at)->subDays( $i );

                $aviso->fill( compact('created_at') )->save();

                $secciones_ids = \Seccion::whereHas('grado.categoria', function( $categorias_q ) use ( $aviso )
                                        {
                                            $categorias_q->where('colegio_id', $aviso->colegio->id );
                                        })
                                        ->pluck('id');

                for ($i=0; $i < $generator->numberBetween( 1, 10) ;  $i++) 
                    \AvisoSeccion::create
                    ([
                        'aviso_id' => $aviso->id,
                        'seccion_id' => $secciones_ids->random(1)->first()
                    ]);

                
        
                \DB::commit();
            }
            catch (\Illuminate\Database\QueryException $e)
            {

                DB::rollBack();
                dd( $e->getMessage() );
            }

        }

    }
}
