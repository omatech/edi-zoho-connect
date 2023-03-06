<?php

namespace Omatech\EdiZohoConnect;

use Illuminate\Support\ServiceProvider;
use Omatech\EdiZohoConnect\Commands\CreateZohoForm;
use Omatech\EdiZohoConnect\Commands\SendForms;

class EdiZohoConnectServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'edi-zoho-connect');

        $this->publishes([
            __DIR__.'/../config/edi-zoho-connect.php' => config_path('edi-zoho-connect.php'),
        ]);

        $this->commands([
            CreateZohoForm::class,
            SendForms::class
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/edi-zoho-connect.php', 'edi-zoho-connect');

        parent::register();
    }

    public function provides()
    {
        return ['edi-zoho-connect'];
    }
}
