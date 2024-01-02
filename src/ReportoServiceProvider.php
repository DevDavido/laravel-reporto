<?php

namespace DevDavido\Reporto;

use DevDavido\Reporto\Middleware\AddReportToHeader;
use DevDavido\Reporto\Middleware\ReportoEnabled;
use Illuminate\Routing\Router;
use Illuminate\Config\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ReportoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/reporting-api.php' => config_path('reporting-api.php')
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/reporting-api.php', 'reporto');

        if ($this->getConfig()->get('reporto.enabled')) {
            $this->getRouter()->pushMiddlewareToGroup('web', AddReportToHeader::class);
            $this->registerRoutes();
        }
    }

    /**
     * Register package routes to application.
     *
     * @return void
     */
    public function registerRoutes(): void
    {
        $routeConfig = [
            'namespace' => 'DevDavido\Reporto\Controllers',
            'prefix' => $this->getConfig()->get('reporto.route_prefix'),
            'middleware' => [ReportoEnabled::class]
        ];
        $this->getRouter()->group($routeConfig, function($router) {
            (new Collection($this->getConfig()->get('reporto.groups')))->each(function($group) use ($router) {
                $router->post(Str::slug($group), [
                    'uses' => 'LogReportController@handle',
                    'as' => 'reporto.' . Str::slug($group)
                ]);
            });
        });
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->app['router'];
    }

    /**
     * @return Repository
     */
    public function getConfig(): Repository
    {
        return $this->app['config'];
    }
}
