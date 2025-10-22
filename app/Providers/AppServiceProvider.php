<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        Model::preventLazyLoading();
        Blade::directive('currency', function ($expression) {
            return "<?php echo 'R$' . number_format($expression, 2, ',', '.'); ?>";
        });

        if ($this->app->environment() === 'local') {
            if (config('app.debug')) {
                $this->enableSQLLog();
            }

        }

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

    }

    private function enableSQLLog(): void
    {
        DB::listen(static function (QueryExecuted $query) {
            $sql = $query->sql;

            foreach ($query->bindings as $binding) {
                $value = is_numeric($binding) ? $binding : "'{$binding}'";
                $sql   = preg_replace('/\?/', $value, $sql, 1);
            }

            if (Str::contains($sql, 'telescope')){
                return;
            }
            Log::channel('sql')->info("Query: {$sql}\nTempo de execução: {$query->time}ms");
        });
    }
}
