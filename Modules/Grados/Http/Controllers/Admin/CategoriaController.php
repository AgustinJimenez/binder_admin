<?php

namespace Modules\Grados\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Grados\Entities\Categoria;
use Modules\Grados\Http\Requests\CreateCategoriaRequest;
use Modules\Grados\Http\Requests\UpdateCategoriaRequest;
use Modules\Grados\Repositories\CategoriaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CategoriaController extends AdminBaseController
{
    /**
     * @var CategoriaRepository
     */
    private $categoria;

    public function __construct(CategoriaRepository $categoria)
    {
        parent::__construct();

        $this->categoria = $categoria;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $categorias = Categoria::where('colegio_id', \Helper::getUserColegioId())->orderBy('nombre')->get();

        return view('grados::admin.categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('grados::admin.categorias.create', compact('colegios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCategoriaRequest $request
     * @return Response
     */
    public function store(CreateCategoriaRequest $request)
    {
        $this->categoria->create(\Helper::addColegioIdRequest($request->all()));

        return redirect()->route('admin.grados.categoria.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('grados::categorias.title.categorias')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Categoria $categoria
     * @return Response
     */
    public function edit(Categoria $categoria)
    {
        //dd($categoria->toArray(), $categoria->grados->toArray());
        return view('grados::admin.categorias.edit', compact('categoria', 'colegios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Categoria $categoria
     * @param  UpdateCategoriaRequest $request
     * @return Response
     */
    public function update(Categoria $categoria, CreateCategoriaRequest $request)
    {
        $this->categoria->update($categoria, $request->all());

        return redirect()->route('admin.grados.categoria.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('grados::categorias.title.categorias')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Categoria $categoria
     * @return Response
     */
    public function destroy(Categoria $categoria)
    {
        return $this->safe_destroy($this->categoria, $categoria, trans('core::core.messages.resource deleted', ['name' => trans('grados::categorias.title.categorias')]), route('admin.grados.categoria.index'));
    }
}
