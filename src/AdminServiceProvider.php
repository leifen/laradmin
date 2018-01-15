<?php

namespace Sundy\Laradmin;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Sundy\Laradmin\Observers\AdminObserver;
use Sundy\Laradmin\Observers\RoleObserver;
use Sundy\Laradmin\Observers\RuleObserver;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laradmin');
        $this->publishes([
            __DIR__.'/resources/assets' => public_path('vendor/laradmin'),
        ], 'public');

        $this->publishes([
            __DIR__.'/resources/views/admin' => resource_path('views/vendor/laradmin'),
        ]);
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        Carbon::setLocale('zh');

        \Sundy\Laradmin\Models\Admin::observe(AdminObserver::class);
        \Sundy\Laradmin\Models\Role::observe(RoleObserver::class);
        \Sundy\Laradmin\Models\Rule::observe(RuleObserver::class);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ .'/routes.php');
    }
}
