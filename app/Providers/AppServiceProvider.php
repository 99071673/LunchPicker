<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /* hieronder heb ik commentaar gezet van wat het doet */
        
        // dit is voor zodat alleen admin gebruikers toegang hebben tot de admin pagina
        Gate::define('access-admin', function ($user) {
            return $user->role === 'admin';
        }); 
        
        // dit zorgt ervoor dat we ingelogd moeten zijn om de routes naar de routes te kunnen gaan
        Route::middleware(['web', 'auth'])
            ->group(base_path('routes/web.php'));

    }
}
