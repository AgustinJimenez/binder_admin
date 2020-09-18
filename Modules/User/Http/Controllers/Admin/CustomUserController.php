<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\User\Contracts\Authentication;
use Modules\User\Events\UserHasBegunResetProcess;
use Modules\User\Http\Requests\CreateCustomUserRequest;
use Modules\User\Http\Requests\UpdateCustomUserRequest;
use Modules\User\Permissions\PermissionManager;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;
use Modules\User\Entities\Sentinel\User;
use Modules\User\Entities\CustomUser;
use Cartalyst\Sentinel\Roles\EloquentRole;
use Modules\Colegios\Entities\Colegio;

class CustomUserController extends BaseUserModuleController
{
    /**
     * @var UserRepository
     */
    private $user;
    /**
     * @var RoleRepository
     */
    private $role;
    /**
     * @var Authentication
     */
    private $auth;

    /**
     * @param PermissionManager $permissions
     * @param UserRepository    $user
     * @param RoleRepository    $role
     * @param Authentication    $auth
     */
    public function __construct(
        PermissionManager $permissions,
        UserRepository $user,
        RoleRepository $role,
        Authentication $auth
    ) {
        parent::__construct();

        $this->permissions = $permissions;
        $this->user = $user;
        $this->role = $role;
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = CustomUser::whereHas('roles', function($q)
        {
            $q->where('name', 'Administrador')
            /*->orWhere('name', 'Responsable')*/;
        })->orderBy('first_name')->orderBy('last_name')->get();

        $currentUser = $this->auth->user();

        return view('user::admin.custom-users.index', compact('users', 'currentUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles = $this->getRoles();
        $colegios = Colegio::orderBy('nombre')->get()->pluck('nombre', 'id')->toArray();

        return view('user::admin.custom-users.create', compact('roles', 'colegios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserRequest $request
     * @return Response
     */
    public function store(CreateCustomUserRequest $request)
    {
        $data = $this->mergeRequestWithPermissions($request);
        if (!$this->validateRole($request->roles))
            return redirect()->back()->withError('No tiene permiso para asignar este rol.');

        $this->user->createWithRoles( \Helper::addColegioIdRequest($data), $request->roles, true);

        return redirect()->route('admin.user.custom-user.index')
            ->withSuccess(trans('user::messages.user created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($id)
    {
        if ($this->isAdmin($id) || $this->isUser())
            return redirect()->route('admin.user.custom-user.index')->withError('Permiso denegado');

        $roles = $this->getRoles();
        $colegios = Colegio::orderBy('nombre')->get()->pluck('nombre', 'id')->toArray();
        $user = User::find($id);

        return view('user::admin.custom-users.edit', compact('roles', 'user', 'colegios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int               $id
     * @param  UpdateUserRequest $request
     * @return Response
     */
    public function update($id, UpdateCustomUserRequest $request)
    {
        if ($this->isAdmin($id) || $this->isUser())
            return redirect()->route('admin.user.custom-user.index')->withError('Permiso denegado');

        if (!$this->validateRole($request->roles))
            return redirect()->back()->withError('No tiene permiso para asignar este rol.');

        $data = $this->mergeRequestWithPermissions($request);

        $this->user->updateAndSyncRoles($id, $data, $request->roles);

        if ($request->get('button') === 'index') {
            return redirect()->route('admin.user.custom-user.index')
                ->withSuccess(trans('user::messages.user updated'));
        }

        return redirect()->route('admin.user.custom-user.index')
            ->withSuccess(trans('user::messages.user updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int      $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->isAdmin($id) || $this->isUser())
            return redirect()->route('admin.user.custom-user.index')->withError('Permiso denegado');

        $this->user->delete($id);

        return redirect()->route('admin.user.custom-user.index')
            ->withSuccess(trans('user::messages.user deleted'));
    }

    public function getRoles()
    {
        return EloquentRole::where('name','Administrador')->get()->pluck('name', 'id')->toArray();
    }

    public function isAdmin($id)
    {
        return User::whereHas('roles', function($q){
                $q->where('name','Admin');
              })->where('id', $id)->exists();
    }

    public function isUser()
    {
        return $this->auth->user()->hasRoleName('Responsable');
    }

    public function validateRole($role_id)
    {
        $role = EloquentRole::where('id', $role_id)->first();
        return $role->name === 'Administrador' || $role->name === 'Responsable';
    }
}