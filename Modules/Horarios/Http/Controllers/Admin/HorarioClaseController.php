<?php

namespace Modules\Horarios\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Horarios\Entities\HorarioClase;
use Modules\Horarios\Http\Requests\CreateHorarioClaseRequest;
use Modules\Horarios\Http\Requests\UpdateHorarioClaseRequest;
use Modules\Horarios\Repositories\HorarioClaseRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class HorarioClaseController extends AdminBaseController
{
    private $horarioclase;
    private $custom_horario_clase_repo;

    public function __construct(
        HorarioClaseRepository $horarioclase, 
        \CustomHorarioClaseRepository $custom_horario_clase_repo
    )
    {
        parent::__construct();

        $this->horarioclase = $horarioclase;
        $this->custom_horario_clase_repo = $custom_horario_clase_repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $horarios_clases = $this->custom_horario_clase_repo->get_clases();
        //dd( $horarios_clases->first()->toArray() );
        return view('horarios::admin.horarioclases.index', compact('horarios_clases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $horario_clase = new \HorarioClase;

        $secciones_list = $this->custom_horario_clase_repo
                            ->query_get_secciones_list()
                            ->get()
                            ->pluck( 'nombre_grado_seccion', 'id' )
                            ->toArray();

        return view('horarios::admin.horarioclases.create', compact('horario_clase', 'secciones_list') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateHorarioClaseRequest $request
     * @return Response
     */
    public function store(CreateHorarioClaseRequest $re)
    {
        $results = $this->custom_horario_clase_repo->create( $re->all() );

        if( $results['error'] )
            return redirect()->route('admin.horarios.horarioclase.index')
            ->withError( $results['message'] ); 

        return redirect()->route('admin.horarios.horarioclase.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('horarios::horarioclases.title.horarioclases')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  HorarioClase $horarioclase
     * @return Response
     */
    public function edit(HorarioClase $horario_clase)
    {
        $secciones_list = $this->custom_horario_clase_repo
                            ->query_get_secciones_list()
                            ->get()
                            ->pluck( 'nombre_grado_seccion', 'id' )
                            ->toArray();

        return view('horarios::admin.horarioclases.edit', compact('horario_clase', 'secciones_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  HorarioClase $horarioclase
     * @param  UpdateHorarioClaseRequest $request
     * @return Response
     */
    public function update( \HorarioClase $horarioclase, UpdateHorarioClaseRequest $request)
    {
        $results = $this->custom_horario_clase_repo->update($horarioclase, $request->all());

        if( $results['error'] )
            return redirect()->route('admin.horarios.horarioclase.index')
            ->withError( $results['message'] ); 

        return redirect()->route('admin.horarios.horarioclase.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('horarios::horarioclases.title.horarioclases')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  HorarioClase $horarioclase
     * @return Response
     */
    public function destroy( \HorarioClase $horarioclase)
    {
        $results = $this->custom_horario_clase_repo->delete($horarioclase);

        if( $results['error'] )
            return redirect()->route('admin.horarios.horarioclase.index')
            ->withError( $results['message'] ); 

        return redirect()->route('admin.horarios.horarioclase.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('horarios::horarioclases.title.horarioclases')]));
    }
}
