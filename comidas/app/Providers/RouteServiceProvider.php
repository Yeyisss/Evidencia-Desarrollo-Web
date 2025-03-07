<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * El nombre del espacio de nombres para las rutas.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Registra los servicios de rutas para la aplicación.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define las rutas para la aplicación.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define las rutas de la API para la aplicación.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace . '\\API')  // Asegúrate de que se use el subnamespace "API"
             ->group(base_path('routes/api.php'));
    }

    /**
     * Define las rutas web para la aplicación.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }
}
