<?php

namespace Modules\Noticias\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Noticias\Entities\Noticia;
use Modules\Noticias\Http\Requests\CreateNoticiaRequest;
use Modules\Noticias\Http\Requests\UpdateNoticiaRequest;
use Modules\Noticias\Repositories\NoticiaRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class NoticiaController extends AdminBaseController
{
    /**
     * @var NoticiaRepository
     */
    private $noticia;
    private $repo_noticia;

    public function __construct( NoticiaRepository $noticia, \CustomNoticiaRepository $repo_noticia )
    {
        parent::__construct();

        $this->noticia = $noticia;
        $this->repo_noticia = $repo_noticia;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('noticias::admin.noticias.index');
    }

    public function index_ajax(Request $re)
    {
        return $this->repo_noticia->get_noticias_ajax_by_colegio_token( $re );
    }

    public function destroy_ajax(\Noticia $noticia)
    {
        return $this->repo_noticia->delete( $noticia );
    }

    public function ver_detalles(\Noticia $noticia)
    {
        $params['contenido_plain'] = true;
        $params['disable_fecha_date_picker'] = true;
        $params['general_attributes'] = 
        [
            'readonly' => 'readonly', 
            'style' => 'background-color: white;', 
            'class' => 'form-control text-center', 
            'required' => 'required'
        ];
        return view("noticias::admin.noticias.partials.fields", compact('noticia', 'params'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $noticia = new \Noticia;
        $noticia->fecha = date('d/m/Y');
        return view('noticias::admin.noticias.create', compact('noticia'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateNoticiaRequest $request
     * @return Response
     */
    public function store(CreateNoticiaRequest $request)
    {
        $results = $this->repo_noticia->create( $request->all() );

        if( $results['error'] )
            return redirect()->route('admin.noticias.noticia.index')->withError( $results['message'] );
        else
            return redirect()->route('admin.noticias.noticia.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('noticias::noticias.title.noticias')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Noticia $noticia
     * @return Response
     */
    public function edit(Noticia $noticia)
    {
        return view('noticias::admin.noticias.edit', compact('noticia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Noticia $noticia
     * @param  UpdateNoticiaRequest $request
     * @return Response
     */
    public function update(Noticia $noticia, UpdateNoticiaRequest $request)
    {
        $results = $this->repo_noticia->update( $noticia, $request->all() );

        if( $results['error'] )
            return redirect()->route('admin.noticias.noticia.index')->withError( $results['message'] );
        else
            return redirect()->route('admin.noticias.noticia.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('noticias::noticias.title.noticias')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Noticia $noticia
     * @return Response
     */
    public function destroy(\Noticia $noticia)
    {
        $results = $this->repo_noticia->delete( $noticia );

        if( $results['error'] )
            return redirect()->route('admin.noticias.noticia.index')->withError( $results['message'] );
        else
            return redirect()->route('admin.noticias.noticia.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('noticias::noticias.title.noticias')]));
    }
}
