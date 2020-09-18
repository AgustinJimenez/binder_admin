<?php

namespace Modules\Colegios\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Colegios\Entities\Colegio;
use Modules\Colegios\Http\Requests\ColegioRequest;
use Modules\Colegios\Repositories\ColegioRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\User\Contracts\Authentication;

class ColegioController extends AdminBaseController
{
    /**
     * @var ColegioRepository
     */
    private $colegio;
    /**
     * @var Authentication
     */
    private $auth;

    public function __construct(ColegioRepository $colegio, Authentication $auth)
    {
        parent::__construct();

        $this->colegio = $colegio;
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $colegios = Colegio::orderBy('nombre')->get();
        $currentUser = $this->auth->user();

        return view('colegios::admin.colegios.index', compact('colegios', 'currentUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $colegio = new \Colegio;

        return view('colegios::admin.colegios.create', compact('colegio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateColegioRequest $request
     * @return Response
     */
    public function store(ColegioRequest $request)
    {
        $token = str_random(80);
        
        while (Colegio::where('token', $token)->exists())
        {
            $token = str_random(80);
        }

        $colegio = \Colegio::create($request->all() + ['token' => $token]);

        event( new \ColegioWasCreated( $colegio, $request->all() ) );

        return redirect()->route('admin.colegios.colegio.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('colegios::colegios.title.colegios')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Colegio $colegio
     * @return Response
     */
    public function edit(Colegio $colegio)
    {
        return view('colegios::admin.colegios.edit', compact('colegio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Colegio $colegio
     * @param  UpdateColegioRequest $request
     * @return Response
     */
    public function update( \Colegio $colegio, ColegioRequest $request)
    {
        $colegio = $this->colegio->update($colegio, $request->all());

        event( new \ColegioWasUpdated( $colegio, $request->all() ) );

        return redirect()->route('admin.colegios.colegio.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('colegios::colegios.title.colegios')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Colegio $colegio
     * @return Response
     */
    public function destroy( \Colegio $colegio)
    {
        event(new \ColegioWasDeleted( $colegio ));
        return $this->safe_destroy($this->colegio, $colegio, trans('core::core.messages.resource deleted', ['name' => trans('colegios::colegios.title.colegios')]), route('admin.colegios.colegio.index'));
    }

    public function set_colegio(Colegio $colegio)
    {
        session()->put('colegio_token', $colegio->token);
        return redirect()->back()->withSuccess('Colegio establecido correctamente');
    }
}
