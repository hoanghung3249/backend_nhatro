<?php

namespace Modules\Motel\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Motel\Events\Handlers\RegisterMotelSidebar;

class MotelServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterMotelSidebar::class);
    }

    public function boot()
    {
        $this->publishConfig('motel', 'permissions');

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
            'Modules\Motel\Repositories\MotelRepository',
            function () {
                $repository = new \Modules\Motel\Repositories\Eloquent\EloquentMotelRepository(new \Modules\Motel\Entities\Motel());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Motel\Repositories\Cache\CacheMotelDecorator($repository);
            }
        );
// add bindings

    }
}
