<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        
        // Création d'une directive blade spéciale, qui parse automatiquement avec Carbon
        // et qui affiche la différence pour un humain.
        // Ceci évite d'avoir trop de logique dans les vues.
        
        Blade::directive('human_diff', function ($expression) {
            return "<?php echo \Carbon\Carbon::parse($expression)->diffForHumans(); ?>";
        });
    }
}
