<?php namespace Modules\Avisos\Repositories ;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
class CustomVistoRepository
{
    private $error_repo;

    public function __construct( \ErrorsRepository $error_repo )
    {
        $this->error_repo = $error_repo;
    }

    public function create(Request $params )
    {

        \DB::beginTransaction();
        try
        {
            if
            ( 
                $params->has('aviso_id') and  
                !\Visto::where('responsable_id', $params->responsable_id )
                ->where('aviso_id', $params->aviso_id)
                ->exists()
            )
            {
                $visto = \Visto::create
                ([
                    'aviso_id' => $params->aviso_id,
                    'responsable_id' => $params->responsable_id
                ]);

                \DB::commit();
                return ['error' => false, 'data' => ['visto' => $visto]];
            }
            
        }
        catch (\Illuminate\Database\QueryException $e)
        {
            \DB::rollBack();
            return 
                    [
                        'error' => true, 
                        'message' => 'Ocurrio un error al intentar crear el visto.',
                        'debug-message' => $this->$error_repo->getErrorByCode( $e->getCode() )
                    ];
        }

        return ['error' => false, 'message' => 'Datos erroneos o faltantes.', 'debug-message' => $params->all() ];
    }
}