<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use App\Gestor\Util;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('APP_ENV') === 'production') {
            $this->app['request']->server->set('HTTPS', true);
         }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(250);

        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        Route::resourceVerbs([
            'create' => 'novo',
            'edit' => 'editar',
            'destroy' => 'excluir'
        ]);

        Blade::component('components.alert', 'alert');
        Blade::component('components.web.alert', 'web_alert');
        
        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('d/m/Y H:i:s'); ?>";
        });

        Blade::directive('date', function ($expression) {
            return "<?php echo ($expression)->format('d/m/Y'); ?>";
        });

        Blade::directive('time', function ($expression) {
            return "<?php echo ($expression)->format('H:i:s'); ?>";
        });

        Blade::if('permissao', function($guard, $route) {
            return Util::permissao($guard, $route);
        });
        
        Blade::directive('telefone', function ($expression) {
            return "<?php echo  \App\Gestor\Util::formatTelefone($expression); ?>";
        });
    }

}
