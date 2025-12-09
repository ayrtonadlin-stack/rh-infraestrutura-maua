<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

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
        // Definir tamanho padrão de string para MySQL
        Schema::defaultStringLength(191);

        // Prevenir lazy loading em desenvolvimento
        Model::preventLazyLoading(! app()->isProduction());

        // Configurações de locale
        setlocale(LC_TIME, 'pt_BR.utf8', 'pt_BR', 'Portuguese_Brazil');
        date_default_timezone_set('America/Sao_Paulo');
    }
}
