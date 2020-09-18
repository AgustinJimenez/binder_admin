<?php

namespace Modules\Avisos\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Avisos\Events\Handlers\RegisterAvisosSidebar;

class AvisosServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterAvisosSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('avisos', array_dot(trans('avisos::avisos')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('avisos', 'permissions');

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
            'Modules\Avisos\Repositories\AvisoRepository',
            function () {
                $repository = new \Modules\Avisos\Repositories\Eloquent\EloquentAvisoRepository(new \Modules\Avisos\Entities\Aviso());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Avisos\Repositories\Cache\CacheAvisoDecorator($repository);
            }
        );
// add bindings

    }
}
