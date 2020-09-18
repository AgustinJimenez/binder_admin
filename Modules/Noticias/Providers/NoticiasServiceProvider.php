<?php

namespace Modules\Noticias\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Noticias\Events\Handlers\RegisterNoticiasSidebar;

class NoticiasServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterNoticiasSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('noticias', array_dot(trans('noticias::noticias')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('noticias', 'permissions');

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
            'Modules\Noticias\Repositories\NoticiaRepository',
            function () {
                $repository = new \Modules\Noticias\Repositories\Eloquent\EloquentNoticiaRepository(new \Modules\Noticias\Entities\Noticia());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Noticias\Repositories\Cache\CacheNoticiaDecorator($repository);
            }
        );
// add bindings

    }
}
