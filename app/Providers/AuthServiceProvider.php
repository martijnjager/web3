<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    protected $gates = [
        'create-project' => 'App\Policies\ProjectPolicy@create',
        'view-project' => 'App\Policies\ProjectPolicy@view',
        'update-project' => 'App\Policies\ProjectPolicy@update',
        'delete-project' => 'App\Policies\ProjectPolicy@delete',
        'all-projects' => 'App\Policies\ProjectPolicy@all',

        'create-task' => 'App\Policies\TaskPolicy@create',
        'update-task' => 'App\Policies\TaskPolicy@update',
        'delete-task' => 'App\Policies\TaskPolicy@delete',

        'create-user' => 'App\Policies\UserPolicy@create',
        'all-user' => 'App\Policies\UserPolicy@all',
        'update-user' => 'App\Policies\UserPolicy@update',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->registerGates();
    }

    /**
     * Register the application's gates.
     *
     * @return void
     */
    public function registerGates()
    {
        foreach ($this->gates as $key => $value) {
            Gate::define($key, $value);
        }
    }
}
