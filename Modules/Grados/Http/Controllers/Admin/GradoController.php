<?php

namespace Modules\Grados\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Grados\Entities\Grado;
use Modules\Grados\Http\Requests\CreateGradoRequest;
use Modules\Grados\Http\Requests\UpdateGradoRequest;
use Modules\Grados\Repositories\GradoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Colegios\Entities\Colegio;
use Modules\Grados\Entities\Categoria;
use Modules\Grados\Entities\Seccion;

class GradoController extends AdminBaseController
{
    /**
     * @var GradoRepository
     */
    private $grado;

    public function __construct(GradoRepository $grado)
    {
        parent::__construct();

        $this->grado = $grado;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $grados = Grado::orderBy('nombre')->whereHas('categoria', function($q)
        {
            $q->where('colegio_id', \Helper::getUserColegioId());
        })->orderBy('orden')->get();

        return view('grados::admin.grados.index', compact('grados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categorias = \Helper::getCategorias();

        return view('grados::admin.grados.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateGradoRequest $request
     * @return Response
     */
    public function store(CreateGradoRequest $request)
    {
        
        if (!\Helper::isValidOption($request->get('categoria_id'), \Helper::getCategorias()))
            return redirect()->back()->withError('La opción elegida no es valida.');

        $this->grado->create($request->all());

        return redirect()->route('admin.grados.grado.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('grados::grados.title.grados')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Grado $grado
     * @return Response
     */
    public function edit(Grado $grado)
    {
        //dd( $grado->toArray(), $grado->secciones->toArray() );
        $categorias = \Helper::getCategorias();

        return view('grados::admin.grados.edit', compact('grado', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Grado $grado
     * @param  UpdateGradoRequest $request
     * @return Response
     */
    public function update(Grado $grado, CreateGradoRequest $request)
    {
        if (!\Helper::isValidOption($request->get('categoria_id'), \Helper::getCategorias()))
            return redirect()->back()->withError('La opción elegida no es valida.');
        
        $this->grado->update($grado, $request->all());

        return redirect()->route('admin.grados.grado.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('grados::grados.title.grados')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Grado $grado
     * @return Response
     */
    public function destroy(Grado $grado)
    {
        return $this->safe_destroy
        (
            $this->grado, 
            $grado, 
            trans('core::core.messages.resource deleted', ['name' => trans('grados::grados.title.grados')]), 
            route('admin.grados.grado.index')
        );
    }
}
