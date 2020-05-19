<?php

namespace App\Providers;

use App\Role;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Resource::withoutWrapping();

        Blade::if('role', function($value) {
            $role = new Role();
            $id = $role->where('value', $value)->get()->first()->id;
            return auth()->user()->role->id <= $id;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
