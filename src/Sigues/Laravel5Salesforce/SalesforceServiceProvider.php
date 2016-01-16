<?php namespace Sigues\Laravel5Salesforce;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 * Class SalesforceServiceProvider
 * @package Davispeixoto\Laravel5Salesforce
 *
 * The Laravel Service Provider for Salesforce Service
 */
class SalesforceServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Bootstrap the configuration
     *
     * @return void
     */
    public function boot()
    {
        $config = __DIR__ . '/config/config.php';
        $this->mergeConfigFrom($config, 'salesforce');
        $this->publishes([$config => config_path('salesforce.php')]);

    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Salesforce', 'Sigues\Laravel5Salesforce\SalesforceFacade');
            $loader->alias('SF', 'Sigues\Laravel5Salesforce\SalesforceFacade');
        });

        $this->app['salesforce'] = $this->app->share(function ($app) {
            return new Salesforce($app['config']);
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['salesforce', 'Sigues\Laravel5Salesforce\Salesforce'];
    }
}
