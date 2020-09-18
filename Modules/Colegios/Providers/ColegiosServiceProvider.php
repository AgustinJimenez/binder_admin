<?php

namespace Modules\Colegios\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Colegios\Events\Handlers\RegisterColegiosSidebar;

class ColegiosServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterColegiosSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('colegios', array_dot(trans('colegios::colegios')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('colegios', 'permissions');

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
            'Modules\Colegios\Repositories\ColegioRepository',
            function () {
                $repository = new \Modules\Colegios\Repositories\Eloquent\EloquentColegioRepository(new \Modules\Colegios\Entities\Colegio());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Colegios\Repositories\Cache\CacheColegioDecorator($repository);
            }
        );
// add bindings

    }
}
