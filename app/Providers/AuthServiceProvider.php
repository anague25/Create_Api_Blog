<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('admin-redacteur-reader-action',function($user){
            return $user->hasAnyRole(['admin','redacteur','reader']);
        });

        Gate::define('admin-redacteur-action',function($user){
            return $user->hasAnyRole(['admin','redacteur']);
        });

        Gate::define('reader-action',function($user){
            return $user->hasAnyRole(['reader']);
        });

       
        Gate::define('admin-action',function($user){
            return $user->isAdmin();
        });

       

    }
}
