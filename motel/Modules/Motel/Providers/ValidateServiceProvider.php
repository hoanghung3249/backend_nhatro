<?php

namespace Modules\Motel\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Motel\Services\Validation\Validate;

class ValidateServiceProvider extends ServiceProvider
{
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
        //
    }

    public function boot(){
        $this->app->validator->resolver(function ($translator, $data, $rules, $messages){
            return new Validate($translator, $data, $rules, $messages);
        });
    }    

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
