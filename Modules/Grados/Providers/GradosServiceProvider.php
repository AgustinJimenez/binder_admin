<?php

namespace Modules\Grados\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Grados\Events\Handlers\RegisterGradosSidebar;

class GradosServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterGradosSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('grados', array_dot(trans('grados::grados')));
            $event->load('categorias', array_dot(trans('grados::categorias')));
            $event->load('seccions', array_dot(trans('grados::seccions')));
            // append translations



        });
    }

    public function boot()
    {
        $this->publishConfig('grados', 'permissions');

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
            'Modules\Grados\Repositories\GradoRepository',
            function () {
                $repository = new \Modules\Grados\Repositories\Eloquent\EloquentGradoRepository(new \Modules\Grados\Entities\Grado());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Grados\Repositories\Cache\CacheGradoDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Grados\Repositories\CategoriaRepository',
            function () {
                $repository = new \Modules\Grados\Repositories\Eloquent\EloquentCategoriaRepository(new \Modules\Grados\Entities\Categoria());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Grados\Repositories\Cache\CacheCategoriaDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Grados\Repositories\SeccionRepository',
            function () {
                $repository = new \Modules\Grados\Repositories\Eloquent\EloquentSeccionRepository(new \Modules\Grados\Entities\Seccion());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Grados\Repositories\Cache\CacheSeccionDecorator($repository);
            }
        );
// add bindings



    }
}
