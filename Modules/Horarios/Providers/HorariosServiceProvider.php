<?php

namespace Modules\Horarios\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Horarios\Events\Handlers\RegisterHorariosSidebar;

class HorariosServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterHorariosSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('horarioclases', array_dot(trans('horarios::horarioclases')));
            $event->load('horarioexamens', array_dot(trans('horarios::horarioexamens')));
            // append translations


        });
    }

    public function boot()
    {
        $this->publishConfig('horarios', 'permissions');

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
            'Modules\Horarios\Repositories\HorarioClaseRepository',
            function () {
                $repository = new \Modules\Horarios\Repositories\Eloquent\EloquentHorarioClaseRepository(new \Modules\Horarios\Entities\HorarioClase());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Horarios\Repositories\Cache\CacheHorarioClaseDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Horarios\Repositories\HorarioExamenRepository',
            function () {
                $repository = new \Modules\Horarios\Repositories\Eloquent\EloquentHorarioExamenRepository(new \Modules\Horarios\Entities\HorarioExamen());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Horarios\Repositories\Cache\CacheHorarioExamenDecorator($repository);
            }
        );
// add bindings


    }
}
