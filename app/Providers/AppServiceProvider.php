<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Events\QueryExecuted;

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
        // Log::channel('customlog')->info('Hello world!!');
        DB::listen(function (QueryExecuted $query) {
            Log::channel('customlog')->info(
                $query->sql,
                $query->bindings,
                $query->time,
                $query->toRawSql()
            );
        });
    }
}
