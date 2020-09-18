<?php

namespace Modules\Grados\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Grados\Entities\Seccion;
use Modules\Grados\Http\Requests\CreateSeccionRequest;
use Modules\Grados\Http\Requests\UpdateSeccionRequest;
use Modules\Grados\Repositories\SeccionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Grados\Entities\Grado;

class SeccionController extends AdminBaseController
{
    /**
     * @var SeccionRepository
     */
    private $seccion;

    public function __construct(SeccionRepository $seccion)
    {
        parent::__construct();

        $this->seccion = $seccion;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $seccions = Seccion::whereHas('grado', function($query)
        {
            $query->whereHas('categoria', function($q)
            {
                $q->where('colegio_id', \Helper::getUserColegioId());
            });
        })->orderBy('nombre')->get();

        return view('grados::admin.seccions.index', compact('seccions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $grados = \Helper::getGrados();

        return view('grados::admin.seccions.create', compact('grados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSeccionRequest $request
     * @return Response
     */
    public function store(CreateSeccionRequest $request)
    {
        if (!\Helper::isValidOption($request->get('grado_id'), \Helper::getGrados()))
            return redirect()->back()->withError('La opción elegida no es valida.');

        $this->seccion->create($request->all());

        return redirect()->route('admin.grados.seccion.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('grados::seccions.title.seccions')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Seccion $seccion
     * @return Response
     */
    public function edit(Seccion $seccion)
    {
        $grados = \Helper::getGrados();

        return view('grados::admin.seccions.edit', compact('seccion', 'grados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Seccion $seccion
     * @param  UpdateSeccionRequest $request
     * @return Response
     */
    public function update(Seccion $seccion, CreateSeccionRequest $request)
    {
        if (!\Helper::isValidOption($request->get('grado_id'), \Helper::getGrados()))
            return redirect()->back()->withError('La opción elegida no es valida.');
        
        $this->seccion->update($seccion, $request->all());

        return redirect()->route('admin.grados.seccion.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('grados::seccions.title.seccions')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Seccion $seccion
     * @return Response
     */
    public function destroy(Seccion $seccion)
    {
        return $this->safe_destroy
        (
            $this->seccion, 
            $seccion, 
            trans('core::core.messages.resource deleted', ['name' => trans('grados::seccions.title.seccions')]), 
            route('admin.grados.seccion.index')
        );
    }
}
