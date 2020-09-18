<?php namespace Modules\Horarios\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Horarios\Entities\HorarioExamen;
use Modules\Horarios\Http\Requests\CreateHorarioExamenRequest;
use Modules\Horarios\Http\Requests\UpdateHorarioExamenRequest;
use Modules\Horarios\Repositories\HorarioExamenRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Horarios\Repositories\CustomHorarioExamenRepository;

class HorarioExamenController extends AdminBaseController
{
    /**
     * @var HorarioExamenRepository
     */
    private $horarioexamen;
    private $custom_horario_examen_repo;
    private $custom_horario_clase_repo;
    
    public function __construct( 
            HorarioExamenRepository $horarioexamen, 
            \CustomHorarioExamenRepository $custom_horario_examen_repo,
            \CustomHorarioClaseRepository $custom_horario_clase_repo
    )
    {
        parent::__construct();

        $this->horarioexamen = $horarioexamen;
        $this->custom_horario_examen_repo = $custom_horario_examen_repo;
        $this->custom_horario_clase_repo = $custom_horario_clase_repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('horarios::admin.horarioexamens.index');
    }

    public function index_ajax( Request $re )
    {
        return $this->custom_horario_examen_repo->get_horarios_examenes_ajax( $this->custom_horario_examen_repo->query_get_horarios_examenes( $re ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $horario_examen = new \HorarioExamen;

        $horario_examen->fecha = date("d/m/Y");

        $secciones_list = $this->custom_horario_examen_repo->get_secciones_list()->get()->pluck('nombre_grado_seccion', 'id')->toArray();

        return view('horarios::admin.horarioexamens.create', compact('horario_examen', 'secciones_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateHorarioExamenRequest $request
     * @return Response
     */
    public function store(CreateHorarioExamenRequest $re)
    {
        $results = $this->custom_horario_examen_repo->create( $re->all() );

        if( $results['error'] )
            return redirect()->route('admin.horarios.horarioexamen.index')
            ->withError( $results['message'] );

        return redirect()->route('admin.horarios.horarioexamen.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('horarios::horarioexamens.title.horarioexamens')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  HorarioExamen $horarioexamen
     * @return Response
     */
    public function edit(HorarioExamen $horario_examen)
    {
        $secciones_list = $this->custom_horario_examen_repo->get_secciones_list()->get()->pluck('nombre_grado_seccion', 'id')->toArray();

        return view('horarios::admin.horarioexamens.edit', compact('horario_examen', 'secciones_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  HorarioExamen $horarioexamen
     * @param  UpdateHorarioExamenRequest $request
     * @return Response
     */
    public function update(HorarioExamen $horarioexamen, UpdateHorarioExamenRequest $request)
    {
        $this->horarioexamen->update($horarioexamen, $request->all());

        return redirect()->route('admin.horarios.horarioexamen.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('horarios::horarioexamens.title.horarioexamens')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  HorarioExamen $horarioexamen
     * @return Response
     */
    public function destroy(HorarioExamen $horarioexamen)
    {
        $this->horarioexamen->destroy($horarioexamen);

        return redirect()->route('admin.horarios.horarioexamen.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('horarios::horarioexamens.title.horarioexamens')]));
    }
}
