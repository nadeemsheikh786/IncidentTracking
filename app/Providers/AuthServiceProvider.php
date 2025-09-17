<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Incident;
use App\Policies\IncidentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Incident::class => IncidentPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
