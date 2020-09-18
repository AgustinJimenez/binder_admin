<?php namespace Modules\Avisos\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Avisos\Entities\Aviso;
use Modules\Avisos\Http\Requests\CreateAvisoRequest;
use Modules\Avisos\Http\Requests\UpdateAvisoRequest;
use Modules\Avisos\Repositories\AvisoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class AvisoController extends AdminBaseController
{
    /**
     * @var AvisoRepository
    */
    private $aviso;
    private $aviso_repo;
    private $grado_repo;
    private $categoria_repo;

    public function __construct(AvisoRepository $aviso, \GradoRepository $grado_repo, \CustomCategoriaRepository $categoria_repo, \CustomAvisoRepository $aviso_repo)
    {
        parent::__construct();

        $this->categoria_repo = $categoria_repo;
        $this->aviso = $aviso;
        $this->grado_repo = $grado_repo;
        $this->aviso_repo = $aviso_repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $re)
    {  
        $colegio_id = \Helper::getSessionColegio()->id;

        if( array_key_exists('por_categoria', $re->all()) )
            $tipo = 'por_categoria';
        else if( array_key_exists('por_grado', $re->all()) )
            $tipo = 'por_grado';
        else if( array_key_exists('por_seccion', $re->all()) )
            $tipo = 'por_seccion';
        else
            $tipo = 'general';

        $avisos = \Aviso::where('tipo', $tipo)->select('titulo', 'fecha', 'firma', 'tipo')->get();

        $fecha_hoy = \Carbon::now();
        $fecha_una_semana_antes = \Carbon::now()->subDays(7);

        $categorias = $this->categoria_repo->getCategoriasGradosSeccionesByColegioId( compact('colegio_id') );

  /*      
        dd(
            \Aviso::skip(100)->take(3)->first()->enviado_recibido
        );
*/        

        return view('avisos::admin.avisos.index', compact('avisos', 'tipo', 'fecha_hoy', 'fecha_una_semana_antes', 'categorias'));
    }

    /**
     * Display a listing of the resource.
     * @param  Request $re
     * @return Datatables
     */
    public function index_ajax(Request $re)
    {
        return $this->aviso_repo->get_avisos_ajax_by_colegio_token( $re );
    }

    public function vistos( \Aviso $aviso, \Categoria $categoria_seleccionada, \Grado $grado_seleccionado, \Seccion $seccion_seleccionada )
    {
        //dd( $aviso, $categoria_seleccionada, $grado_seleccionado, $seccion_seleccionada );
        $categorias_del_aviso = $this->aviso_repo
            ->query_get_categorias_from_aviso_id( $aviso->id )
            ->get();
        return view( 'avisos::admin.avisos.vistos', compact('aviso', 'categoria_seleccionada', 'grado_seleccionado', 'seccion_seleccionada', 'categorias_del_aviso') );
    }

    public function vistos_index_ajax( Request $re)
    {
        return $this->aviso_repo->get_aviso_responsables_ajax( $re );
    }

    public function ver_detalle( \Aviso $aviso )
    {   
        $categorias = $this->categoria_repo->query_get_categorias_from_secciones_ids( $aviso->secciones_ids )->select('id', 'nombre')->get();

       //dump( 'Secciones ids del aviso =>', $aviso->secciones_ids, 'Query Result =>', $categorias->toArray() );
        
        return view('avisos::admin.avisos.partials.simple-fields', compact('aviso', 'categorias', 'secciones_ids') );
    }

    public function delete_avisos_ajax(Request $re)
    {
        $array_response = $this->aviso_repo->delete_many_avisos_by_ids( explode(',', $re->data) );
        return response()->json( $array_response );
    }

    public function create_general(Request $re)
    {
        return $this->create($re);
    }
    public function create_por_categoria(Request $re)
    {
        $re['por_categoria'] = '';
        return $this->create($re);
    }
    public function create_por_grado(Request $re)
    {
        $re['por_grado'] = '';
        return $this->create($re);
    }
    public function create_por_seccion(Request $re)
    {
        $re['por_seccion'] = '';
        return $this->create($re);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $re)
    {
        $aviso = new Aviso;
        $titulo = $nombre_field = $tipos_collection = null;
        if( array_key_exists('por_categoria', $re->all()) )
        {
            $tipo = 'por_categoria';
            $titulo = 'Categorias';
            $nombre_field = 'categorias_ids';
            $tipos_collection = ( $tipo == 'por_categoria' ) ? \Helper::getCategorias() : null;
        }
        else if( array_key_exists('por_grado', $re->all()) )
        {
            $tipo = 'por_grado';
            $titulo = 'Grados';
            $nombre_field = 'grados_ids';
            $tipos_collection = ( $tipo == 'por_grado' ) ? \Helper::getGrados() : null;
        }
        else if( array_key_exists('por_seccion', $re->all()) )
        {
            $tipo = 'por_seccion';
            $titulo = 'Secciones';
            $nombre_field = 'secciones_ids';
            $tipos_collection = ( $tipo == 'por_seccion' ) ? 
                                $this->grado_repo->query_get_grados_by_colegio_token()->select('id', 'nombre', 'orden')->get() :
                                null;
        }
        else
            $tipo = 'general';
        return view('avisos::admin.avisos.create', compact('tipo', 'aviso', 'tipos_collection', 'titulo', 'nombre_field'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAvisoRequest $request
     * @return Response
     */
    public function store(Request $re)
    {
        $results = $this->aviso_repo->create_aviso_procedure( $re->all() );
        if( $results['error'] )
            return redirect()->back()->withInput()->withError($results['message']);
        else
            return redirect()->route('admin.avisos.aviso.index')->withSuccess(trans('core::core.messages.resource created', ['name' => trans('avisos::avisos.title.avisos')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Aviso $aviso
     * @return Response
     */
    public function edit(Aviso $aviso)
    {
        //return view('avisos::admin.avisos.edit', compact('aviso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Aviso $aviso
     * @param  UpdateAvisoRequest $request
     * @return Response
     */
    public function update(Aviso $aviso, UpdateAvisoRequest $request)
    {
        //$this->aviso->update($aviso, $request->all());

        //return redirect()->route('admin.avisos.aviso.index')
          //  ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('avisos::avisos.title.avisos')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Aviso $aviso
     * @return Response
     */
    public function destroy(Aviso $aviso)
    {
        //$this->aviso->destroy($aviso);

        //return redirect()->route('admin.avisos.aviso.index')
          //  ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('avisos::avisos.title.avisos')]));
    }
}
