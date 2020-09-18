<?php

namespace Modules\Alumnos\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Alumnos\Entities\Alumno;
use Modules\Alumnos\Http\Requests\CreateAlumnoRequest;
use Modules\Alumnos\Http\Requests\UpdateAlumnoRequest;
use Modules\Alumnos\Repositories\AlumnoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Yajra\Datatables\Datatables;
use Modules\Grados\Entities\Grado;
use Modules\Grados\Entities\Seccion;
use Modules\Alumnos\Entities\Relacion;
use Modules\Responsables\Entities\Responsable;
use Modules\User\Repositories\UserRepository;
use Cartalyst\Sentinel\Roles\EloquentRole;

class AlumnoController extends AdminBaseController
{
    /**
     * @var AlumnoRepository
     */
    private $alumno;
    private $user;

    public function __construct(AlumnoRepository $alumno, UserRepository $user)
    {
        parent::__construct();

        $this->alumno = $alumno;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $grados = \Helper::getGrados();

        return view('alumnos::admin.alumnos.index', compact('grados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $grados = \Helper::getGrados();

        return view('alumnos::admin.alumnos.create', compact('grados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAlumnoRequest $request
     * @return Response
     */
    public function store(CreateAlumnoRequest $request)
    {
        
        $grado_id_is_not_valid = !\Helper::isValidOption($request->get('grado_id'), \Helper::getGrados());
        $seccion_id_is_not_valid = (\Helper::colegioTieneVariasSecciones() and !\Helper::isValidOption( $request->get('seccion_id'), \Helper::getSecciones() ));

        if ($grado_id_is_not_valid or $seccion_id_is_not_valid)
            return redirect()->back()->withError('La opción elegida no es valida.');

        $request['fecha_nacimiento'] = \Helper::dateTo($request->get('fecha_nacimiento'));

 
        $user = $this->user->createWithRoles($this->processUserData($request->all(), true), $this->getDefaultRole(), true);

        $this->alumno->create($request->all() + ['user_id' => $user->id]);

        return redirect()->route('admin.alumnos.alumno.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('alumnos::alumnos.title.alumnos')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Alumno $alumno
     * @return Response
     */
    public function edit(Alumno $alumno)
    {
        $grados = \Helper::getGrados();
        $secciones = Seccion::whereHas('grado', function($query)
                {
                    $query->whereHas('categoria', function($q)
                    {
                        $q->where('colegio_id', \Helper::getUserColegioId());
                    });
                })->where('grado_id', $alumno->grado_id)->orderBy('nombre')
                ->get()->pluck('nombre', 'id')->toArray();

        return view('alumnos::admin.alumnos.edit', compact('alumno', 'grados', 'secciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Alumno $alumno
     * @param  UpdateAlumnoRequest $request
     * @return Response
     */
    public function update(Alumno $alumno, UpdateAlumnoRequest $request)
    {
        $grado_id_is_not_valid = !\Helper::isValidOption($request->get('grado_id'), \Helper::getGrados());
        $seccion_id_is_not_valid = (\Helper::colegioTieneVariasSecciones() and !\Helper::isValidOption( $request->get('seccion_id'), \Helper::getSecciones() ));

        if ($grado_id_is_not_valid or $seccion_id_is_not_valid)
            return redirect()->back()->withError('La opción elegida no es valida.');

        $request['fecha_nacimiento'] = \Helper::dateTo($request->get('fecha_nacimiento'));
        $this->user->updateAndSyncRoles($alumno->user->id, $this->processUserData($request->all()), $this->getDefaultRole());
        $this->alumno->update($alumno, $request->all());

        return redirect()->route('admin.alumnos.alumno.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('alumnos::alumnos.title.alumnos')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Alumno $alumno
     * @return Response
     */
    public function destroy(Alumno $alumno)
    {
        $this->alumno->destroy($alumno);

        return redirect()->route('admin.alumnos.alumno.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('alumnos::alumnos.title.alumnos')]));
    }

    public function indexAjax(Request $request)
    {
        $query = Alumno::whereHas('grado', function($grado) use ($request)
        {
            $grado->whereHas('categoria', function($categoria)
            {
                $categoria->where('colegio_id', \Helper::getUserColegioId());
            });

            if ($request->has('grado_id') && $request->get('grado_id') != null)
                $grado->where('id', $request->get('grado_id'));
        });

        if ($request->has('seccion_id') && $request->get('seccion_id') != null)
                $query->where('seccion_id', $request->get('seccion_id'));

        $query->orderBy('ci')
        ->orderBy('nombre')
        ->orderBy('apellido');

        if ($request->has('nombre') && trim($request->get('nombre')) !== '')
            $query->where('nombre', 'like', "%{$request->get('nombre')}%");
        if ($request->has('apellido') && trim($request->get('apellido')) !== '')
            $query->where('apellido', 'like', "%{$request->get('apellido')}%");
        if ($request->has('ci') && trim($request->get('ci')) !== '')
            $query->where('ci', 'like', "{$request->get('ci')}%");

        if ($request->has('add_index'))
            return $this->addIndex($query, $request->get('responsable_id'));
        else
            return $this->normalIndex($query);
    }

    public function normalIndex($query)
    {
        $object = Datatables::of($query)
            ->addColumn('action', function ($row)
            {
                $edit = route('admin.alumnos.alumno.edit', [$row->id]);
                $destroy = route('admin.alumnos.alumno.destroy', [$row->id]);
                $responsables = route('admin.alumnos.alumno.index-responsables', [$row->id]);

                $append = "<a class='btn btn-primary btn-flat' href='". $responsables ."'>Responsables (".$row->relaciones->count().")</button>";

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
            ->editColumn('fecha_nacimiento', function ($row) {
                return $row->withHref($row->fecha_nacimiento);
            })
            ->editColumn('grado', function ($row) {
                return $row->withHref($row->grado->nombre);
            })
            ->editColumn('seccion', function ($row)
            {
                $seccion = 'N/A';
                if ($row->seccion)
                    $seccion = $row->seccion->nombre;
                return $row->withHref($seccion);
            })
            ->escapeColumns([])
            ->make(true);

        return $object;
    }

    public function addIndex($query, $responsable_id)
    {
        $object = Datatables::of($query)
            ->addColumn('action', function ($row) use ($responsable_id)
            {
                if (Relacion::where('alumno_id', $row->id)->where('responsable_id', $responsable_id)->exists())
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
            ->editColumn('fecha_nacimiento', function ($row) {
                return $row->fecha_nacimiento;
            })
            ->editColumn('grado', function ($row) {
                return $row->grado->nombre;
            })
            ->editColumn('seccion', function ($row)
            {
                $seccion = empty($row->seccion) ? 'N/A' : $row->seccion->nombre;
                return $seccion;
            })
            ->escapeColumns([])
            ->make(true);

        return $object;
    }

    public function indexResponsables(Alumno $alumno)
    {
        $relaciones = Relacion::where('alumno_id', $alumno->id)->get();

        return view('alumnos::admin.alumnos.index-responsables', compact('alumno', 'relaciones'));
    }

    public function addResponsable(Request $request)
    {
        if (Relacion::where('alumno_id', $request->get('alumno_id'))->where('responsable_id', $request->get('responsable_id'))->exists())
            return redirect()->back()->withError('El responsable ya esta asociado al alumno');
        else
            Relacion::create($request->all());

        return redirect()->back()->withSuccess('Se ha agregado el responsable correctamente');
    }

    public function removeResponsable($id)
    {
        Relacion::destroy($id);

        return redirect()->back()->withSuccess('Relación eliminada correctamente.');
    }

    public function remoteChained(Request $request)
    {
        $data[] = \Helper::addDefaultOptionArray();
        $data[] = Seccion::whereHas('grado', function($query)
                {
                    $query->whereHas('categoria', function($q)
                    {
                        $q->where('colegio_id', \Helper::getUserColegioId());
                    });
                })->where('grado_id', $request->get('grado_id'))->orderBy('nombre')
                ->get()->pluck('nombre', 'id')->toArray();
        return json_encode($data);
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
        $role = EloquentRole::where('name', 'Alumno')->first();

        return $role->id;
    }














}