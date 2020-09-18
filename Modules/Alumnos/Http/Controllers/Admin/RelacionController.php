<?php

namespace Modules\Alumnos\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Alumnos\Entities\Relacion;
use Modules\Alumnos\Http\Requests\CreateRelacionRequest;
use Modules\Alumnos\Http\Requests\UpdateRelacionRequest;
use Modules\Alumnos\Repositories\RelacionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class RelacionController extends AdminBaseController
{
    /**
     * @var RelacionRepository
     */
    private $relacion;

    public function __construct(RelacionRepository $relacion)
    {
        parent::__construct();

        $this->relacion = $relacion;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$relacions = $this->relacion->all();

        return view('alumnos::admin.relacions.index', compact(''));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('alumnos::admin.relacions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRelacionRequest $request
     * @return Response
     */
    public function store(CreateRelacionRequest $request)
    {
        $this->relacion->create($request->all());

        return redirect()->route('admin.alumnos.relacion.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('alumnos::relacions.title.relacions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Relacion $relacion
     * @return Response
     */
    public function edit(Relacion $relacion)
    {
        return view('alumnos::admin.relacions.edit', compact('relacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Relacion $relacion
     * @param  UpdateRelacionRequest $request
     * @return Response
     */
    public function update(Relacion $relacion, UpdateRelacionRequest $request)
    {
        $this->relacion->update($relacion, $request->all());

        return redirect()->route('admin.alumnos.relacion.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('alumnos::relacions.title.relacions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Relacion $relacion
     * @return Response
     */
    public function destroy(Relacion $relacion)
    {
        $this->relacion->destroy($relacion);

        return redirect()->route('admin.alumnos.relacion.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('alumnos::relacions.title.relacions')]));
    }
}
