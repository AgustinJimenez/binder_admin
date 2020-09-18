<?php namespace Modules\Responsables\Repositories;

use Cartalyst\Sentinel\Roles\EloquentRole;
use Modules\Colegios\Repositories\CustomColegioRepository;

class CustomUserResponsableRepository
{

    private $user_repo;
    private $responsables;
    private $colegio_repo;

    public function __construct( \UserRepository $user_repo, \Responsable $responsables, \CustomColegioRepository $colegio_repo ) 
    { 
        $this->user_repo = $user_repo;
        $this->responsables = $responsables;
        $this->colegio_repo = $colegio_repo;
    } 

    public function query_get_responsables_by_colegio_token( $colegio_token = null )
    {
        return $this->responsables->whereHas('user.colegio', function( $colegio_query )
                {
                    $colegio_query->where('token', $this->colegio_repo->get_colegio_session_token() );
                });
    }

    public function get_cantidad_responsables_pendientes()
    {
        return $this->query_get_responsables_by_colegio_token( $colegio_token = null )->where('estado', 'pendiente')->count();
    }

    public function create_responsable_with_user_with_suscripciones( $responsable_fields, $secciones_id )
    {
        $responsable_fields = collect($responsable_fields);

        $user = $this->user_repo->createWithRolesFromCli( $responsable_fields->except(['nombre', 'apellido', 'telefono', 'estado', 'tipo_encargado', 'password_confirmation'])->toArray(), $this->getDefaultRole(), true ); 
       // dd($responsable_fields->toArray());
        
        $responsable = \Responsable::create( $responsable_fields->except(['email', 'password', 'password_confirmation', 'colegio_id', 'first_name', 'last_name'])->toArray() + ['user_id' => $user->id] );

        $this->create_responsable_access( $responsable->id );

        foreach ($secciones_id as $key => $seccion_id)
            \ResponsableSuscripcionSeccion::create(['responsable_id' => $responsable->id, 'seccion_id' => $seccion_id, 'dispositivo_token' => $key]);
            
        return $responsable;
    }

    public function getDefaultRole()
    {
        $role = EloquentRole::where('name', 'Responsable')->first();

        if(!$role)
            dd("ERROR, CHECK getDefaultRole() AT Modules/Responsables/Repositories/Eloquent/EloquentResponsableRepository.php");

        return $role->id;
    }

    public function create_responsable_access( $responsable_id )
    {
        while ( \ResponsableAccess::where('token', $token = str_random( 16 ))->exists() ){}

        return \ResponsableAccess::create
        ([
            'responsable_id' => $responsable_id,
            'token' => $token
        ]);

    }

}