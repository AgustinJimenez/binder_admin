<?php

namespace Modules\Alumnos\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Alumnos\Events\Handlers\RegisterAlumnosSidebar;

class AlumnosServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterAlumnosSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('alumnos', array_dot(trans('alumnos::alumnos')));
            $event->load('relacions', array_dot(trans('alumnos::relacions')));
            // append translations


        });
    }

    public function boot()
    {
        $this->publishConfig('alumnos', 'permissions');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Alumnos\Repositories\AlumnoRepository',
            function () {
                $repository = new \Modules\Alumnos\Repositories\Eloquent\EloquentAlumnoRepository(new \Modules\Alumnos\Entities\Alumno());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Alumnos\Repositories\Cache\CacheAlumnoDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Alumnos\Repositories\RelacionRepository',
            function () {
                $repository = new \Modules\Alumnos\Repositories\Eloquent\EloquentRelacionRepository(new \Modules\Alumnos\Entities\Relacion());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Alumnos\Repositories\Cache\CacheRelacionDecorator($repository);
            }
        );
// add bindings


    }
}
