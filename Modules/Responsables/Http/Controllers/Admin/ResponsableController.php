<?php 
 
namespace Modules\Responsables\Http\Controllers\Admin; 
 
use Illuminate\Http\Request; 
use Illuminate\Http\Response; 
use Modules\Responsables\Entities\Responsable; 
use Modules\Responsables\Http\Requests\CreateResponsableRequest; 
use Modules\Responsables\Http\Requests\UpdateResponsableRequest; 
use Modules\Responsables\Repositories\ResponsableRepository; 
use Modules\Core\Http\Controllers\Admin\AdminBaseController; 
use Modules\User\Repositories\UserRepository; 
use Cartalyst\Sentinel\Roles\EloquentRole; 
use Yajra\Datatables\Datatables; 
use Modules\Alumnos\Entities\Relacion; 
 
class ResponsableController extends AdminBaseController 
{ 
    /** 
     * @var ResponsableRepository 
     */ 
    private $responsable; 
    /** 
     * @var UserRepository 
     */ 
    private $user; 
/** 
     * @var NotificationsRepository 
     */ 
    private $notification_repo;

    private $seccion_repo;
    private $grado_repo;
    private $categoria_repo;

    public function __construct
    (
        ResponsableRepository $responsable, 
        UserRepository $user, 
        \NotificationsRepository $notification_repo,
        \CustomSeccionRepository $seccion_repo,
        \CustomGradoRepository $grado_repo,
        \CustomCategoriaRepository $categoria_repo
    ) 
    { 
        parent::__construct(); 
 
        $this->responsable = $responsable; 
        $this->user = $user; 
        $this->notification_repo = $notification_repo;
        $this->seccion_repo = $seccion_repo;
        $this->grado_repo = $grado_repo;
        $this->categoria_repo = $categoria_repo;
    } 
 
    /** 
     * Display a listing of the resource. 
     * 
     * @return Response 
     */ 
    public function index(Request $re) 
    { 
        $colegio_id = \Helper::getSessionColegio()->id;

//        $secciones = $this->seccion_repo->queryGetSeccionesByColegioId( $colegio_id );

        $categorias = $this->categoria_repo->getCategoriasGradosSeccionesByColegioId( compact('colegio_id') );

        return view('responsables::admin.responsables.index', compact('categorias') ); 
    } 
 
    /** 
     * Show the form for creating a new resource. 
     * 
     * @return Response 
     */ 
    public function create() 
    { 
        return view('responsables::admin.responsables.create'); 
    } 
    
    /** 
     * Store a newly created resource in storage. 
     * 
     * @param  CreateResponsableRequest $request 
     * @return Response 
     */ 
    public function store(CreateResponsableRequest $request) 
    { 
        $user = $this->user->createWithRoles($this->processUserData($request->all(), true), $this->getDefaultRole(), true); 
 
        $this->responsable->create($request->except(['email', 'password', 'password_confirmation']) + ['user_id' => $user->id]); 
 
        return redirect()->route('admin.responsables.responsable.index') 
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('responsables::responsables.title.responsables')])); 
    } 
 
    /** 
     * Show the form for editing the specified resource. 
     * 
     * @param  Responsable $responsable 
     * @return Response 
     */ 
    public function edit(Responsable $responsable) 
    { 
        return view('responsables::admin.responsables.edit', compact('responsable')); 
    } 
    
    public function get_suscripciones( Responsable $responsable )
    {
        /*
        dd(
            $responsable->suscripciones_secciones_ids,
            $responsable->categorias_grados_secciones_suscripciones
        );
        */
        $categorias_suscripciones = $responsable->categorias_grados_secciones_suscripciones;

        return view('responsables::admin.responsables.partials.suscripciones', compact('categorias_suscripciones'));
    }

    /** 
     * Update the specified resource in storage. 
     * 
     * @param  Responsable $responsable 
     * @param  UpdateResponsableRequest $request 
     * @return Response 
     */ 
    public function update(Responsable $responsable, UpdateResponsableRequest $request) 
    { 
        $this->user->updateAndSyncRoles($responsable->user->id, $this->processUserData($request->all()), $this->getDefaultRole()); 
 
        $this->responsable->update($responsable, $request->except(['email', 'password', 'password_confirmation', 'user_id'])); 
 
        return redirect()->route('admin.responsables.responsable.index') 
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('responsables::responsables.title.responsables')])); 
    } 
 
    /** 
     * Remove the specified resource from storage. 
     * 
     * @param  Responsable $responsable 
     * @return Response 
     */ 
    public function destroy(Responsable $responsable) 
    { 
        $destroy_responsable_result = $this->responsable->destroy($responsable); 
        $destroy_user_result = $this->responsable->destroy($responsable->user); 
 
        if( is_string( $destroy_responsable_result) ) 
            return redirect()->back()->withError( $destroy_responsable_result ); 
 
        if( is_string( $destroy_user_result ) ) 
            return redirect()->back()->withError( $destroy_user_result ); 
 
        return redirect()->route('admin.responsables.responsable.index') 
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('responsables::responsables.title.responsables')])); 
    } 
 
    public function indexAjax(Request $request) 
    { 
        $query = Responsable::whereHas('user', function($query) use ($request) 
        { 
            $query->whereHas('colegio', function($q) 
            { 
                $q->where('colegio_id', \Helper::getUserColegioId()); 
            }); 
 
            if ($request->has('email') && trim($request->get('email')) !== '') 
                $query->where('email', 'like', "%{$request->get('email')}%" ); 
 
        })
        ->orderBy('nombre')
        ->orderBy('apellido'); 

        if( $request->filled('estado') )
            $query->where('estado', $request->estado);

        if ($request->has('seccion_id') && trim($request->get('seccion_id')) !== '') 
            $query->whereHas('suscripciones', function($suscripciones_q) use ($request) 
            {
                $suscripciones_q->where('seccion_id', $request->seccion_id);
                if ($request->has('grado_id') && trim($request->get('grado_id')) !== '') 
                    $suscripciones_q->whereHas('seccion.grado', function($grado_q) use ($request) 
                    {
                        $grado_q->where('id', $request->grado_id);
                    }); 

            }); 
        if ($request->has('nombre') && trim($request->get('nombre')) !== '') 
            $query->where('nombre', 'like', "%{$request->get('nombre')}%"); 
        if ($request->has('apellido') && trim($request->get('apellido')) !== '') 
            $query->where('apellido', 'like', "%{$request->get('apellido')}%"); 
        if ($request->has('ci') && trim($request->get('ci')) !== '') 
            $query->where('ci', 'like', "{$request->get('ci')}%"); 
 
        if ($request->has('add_index')) 
            return $this->addIndex($query, $request->get('alumno_id')); 
        else 
            return $this->normalIndex($query, $request); 
    } 
 
    public function normalIndex( $query, Request $re ) 
    { 
        $object = Datatables::of($query) 
            ->filter(function ($responsable_q) use ($re) 
            {
                $responsable_q->whereHas('suscripciones', function( $suscripciones_q ) use ($re) 
                {

                    if( $re->filled('seccion_id') ) 
                        $suscripciones_q->whereIn('seccion_id', [$re->seccion_id]);
                    else if( $re->filled('grado_id') )
                        $suscripciones_q->whereHas('seccion', function( $seccion_q ) use ($re) 
                        {
                            $seccion_q->whereHas('grado', function( $grado_q ) use ($re) 
                            {
                                $grado_q->whereIn('id', [$re->grado_id] );
                            });
                        });
                    else if( $re->filled('categoria_id') )
                        $suscripciones_q->whereHas('seccion', function( $seccion_q ) use ($re) 
                        {
                            $seccion_q->whereHas('grado', function( $grado_q ) use ($re) 
                            {
                                $grado_q->whereHas('categoria', function( $categoria_q ) use ($re) 
                                {
                                    $categoria_q->whereIn('id', [$re->categoria_id] );
                                });
                            });
                        });
                });
            })
            ->addColumn('action', function ($row) 
            { 
                $edit = route('admin.responsables.responsable.edit', [$row->id]); 
                $destroy = route('admin.responsables.responsable.destroy', [$row->id]); 
                $alumnos = route('admin.responsables.responsable.index-alumnos', [$row->id]); 
 
                $append = "<a class='btn btn-primary btn-flat' href='". $alumnos ."'>Alumnos (".$row->relaciones->count().")</a>"; 
                
                if( $suscripciones_count = $row->suscripciones()->count() )
                    $append .= "<button class='btn btn-warning btn-flat responsable-ver-suscripciones' responsable_id='". $row->id ."'>
                                    Suscripciones (". $suscripciones_count . ")
                                </button>";
 
                return \Helper::getTableButtons($edit, $destroy, $append); 
            }) 
            ->editColumn('nombre', function ($row) { 
                return $row->withHref($row->nombre); 
            }) 
            ->editColumn('apellido', function ($row) { 
                return $row->withHref($row->apellido); 
            }) 
            ->editColumn('ci', function ($row) { 
                return $row->withHref($row->ci); 
            }) 
            ->editColumn('email', function ($row) { 
                return $row->withHref($row->user->email); 
            }) 
            ->editColumn('tipo_encargado', function ($row) { 
                return $row->withHref($row->tipo_encargado); 
            }) 
            ->editColumn('estado', function ($row)  
            { 
                return '<button class="btn btn-sm ' . $row->subclass . ' estado-modal" responsable_id="' . $row->id . '">' . $row->estado . '</button>'; 
            }) 
            ->setRowClass( function ($tabla) 
            { 
                return "text-center"; 
            })
            ->escapeColumns([]) 
            ->make(true); 

        $data = $object->getData(true);
        
        $data['debug_message'] = $re->all();

        return response()->json( $data );
    } 
 
    public function addIndex($query, $alumno_id) 
    { 
        $object = Datatables::of($query) 
            ->addColumn('action', function ($row) use ($alumno_id) 
            { 
                if ( Relacion::where('alumno_id', $alumno_id)->where('responsable_id', $row->id)->exists() ) 
                    $button = "<button class='btn btn-success btn-flat'>Agregado</button>"; 
                else 
                    $button = "<button class='btn btn-primary btn-flat add-btn' data-id='".$row->id."'>Agregar</button>"; 
                return $button; 
            }) 
            ->editColumn('nombre', function ($row) { 
                return $row->nombre; 
            }) 
            ->editColumn('apellido', function ($row) { 
                return $row->apellido; 
            }) 
            ->editColumn('ci', function ($row) { 
                return $row->ci; 
            }) 
            ->editColumn('email', function ($row) { 
                return $row->user->email; 
            }) 
            ->escapeColumns([]) 
            ->make(true); 
 
        return $object; 
    } 
 
    public function indexAlumnos(Responsable $responsable) 
    { 
        $relaciones = Relacion::where('responsable_id', $responsable->id)->get(); 
        $grados = \Helper::getGrados(); 
 
        return view('responsables::admin.responsables.index-alumnos', compact('responsable', 'relaciones', 'grados')); 
    } 
 
    public function removeAlumno($id) 
    { 
        Relacion::destroy($id); 
 
        return redirect()->back()->withSuccess('Relación eliminada correctamente.'); 
    } 
 
    public function processUserData($attributes, $create = false) 
    { 
        $data = []; 
        foreach ($attributes as $key => $value) 
        { 
            if ($key === 'nombre') 
                $data['first_name'] = $value; 
            if ($key === 'apellido') 
                $data['last_name'] = $value; 
            if ($key === 'email') 
                $data[$key] = $value; 
            if ($key === 'password') 
                $data[$key] = $value; 
        } 
 
        if ($create) 
        { 
            $data['roles'] = $this->getDefaultRole(); 
            return \Helper::addColegioIdRequest($data); 
        } 
        else 
        { 
            $data['activated'] = true; 
            return $data; 
        } 
    } 
 
    public function getDefaultRole() 
    { 
        $role = EloquentRole::where('name', 'Responsable')->first(); 
 
        return $role->id; 
    } 
 
    public function update_responsable_ajax(Responsable $responsable, Request $re) 
    { 

        $is_valid_for_notifications_if_aprobado = $this->responsable->validate_for_notification_if_aprobado( $responsable, $re->all() );

        if( $is_valid_for_notifications_if_aprobado )
        {
            $notification_results = $this
            ->notification_repo
            ->responsable_was_aprobado
            ( 
                $responsable->nombre_apellido . " fue aprobado.", 
                "Su solicitud de registro en la aplicacion fue aprobada, ya puede logearse.", 
                $responsable->access->last_login_device_token
            );
            return [ 'status' => $responsable->update( $re->responsable ), 'message' => ($notification_results['error'] ? $notification_results['message'] : null ) ]; 
        }
            
        return [ 'status' => $responsable->update( $re->responsable ) ]; 
    } 
}