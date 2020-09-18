<?php

namespace Modules\Responsables\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Responsables\Events\Handlers\RegisterResponsablesSidebar;

class ResponsablesServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterResponsablesSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('responsables', array_dot(trans('responsables::responsables')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('responsables', 'permissions');

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
            'Modules\Responsables\Repositories\ResponsableRepository',
            function () {
                $repository = new \Modules\Responsables\Repositories\Eloquent\EloquentResponsableRepository(new \Modules\Responsables\Entities\Responsable());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Responsables\Repositories\Cache\CacheResponsableDecorator($repository);
            }
        );
// add bindings

    }
}
