<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Guards\KeycloakGuard;

class KeycloakServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        Auth::extend('keycloak', function ($app, $name, array $config) {
            return new KeycloakGuard(Auth::createUserProvider($config['provider']), $app->request);
        });
    }
}
