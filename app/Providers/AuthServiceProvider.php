<?php

namespace App\Providers;

use App\Models\Vacancy\Vacancy;
USE App\Models\Users\Users;
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
     // 'App\Model' => 'App\Policies\ModelPolicy',
     \App\Models\Vacancy\Vacancy::class => \App\Policies\Vacancy\VacancyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //

        Gate::define('edit-applications', function ($user,$author=0) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $user->id == $author || $privilege>=6;
        });
        Gate::define('create-applications', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=2;
        });
        Gate::define('delete-applications', function ($user,$author=0) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6 || $user->id==$author;
        });
        Gate::define('search-applications', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=2;
        });
        Gate::define('get-applications', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=0;
        });

        Gate::define('edit-vacancy', function ($user,$author) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $user->id == $author || $privilege>=6;
        });
        Gate::define('create-vacancy', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=2;
        });
        Gate::define('delete-vacancy', function ($user,$author) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6 || $user->id==$author;
        });
        Gate::define('search-vacancy', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=2;
        });
        Gate::define('get-vacancy', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=0;
        });

        //

        Gate::define('get-tickets', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-tickets', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-tickets', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-tickets', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-tickets', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        Gate::define('get-vacancy-images', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-vacancy-images', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-vacancy-images', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-vacancy-images', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-vacancy-images', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('get-vacancy-category', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-vacancy-category', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-vacancy-category', function ($user) {
                     $privilege=app("App\Http\Controllers\Users\Privileges")->get();
                     return $privilege>=6;
                });
        Gate::define('delete-vacancy-category', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-vacancy-category', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        Gate::define('search-vacancy-clients', function ($user) {
              $privilege=app("App\Http\Controllers\Users\Privileges")->get();
              return $privilege>=6;
        });
        Gate::define('get-vacancy-clients', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-vacancy-clients', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-vacancy-clients', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-vacancy-clients', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-vacancy-clients', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('create-clients', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-clients', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('get-clients', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-clients', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-clients', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('get-clients-address', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-clients-address', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-clients-address', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-clients-address', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-clients-address', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('get-clients-messenger', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-clients-messenger', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-clients-messenger', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-clients-messenger', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-clients-messenger', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('get-clients-phones', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-clients-phones', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-clients-phones', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-clients-phones', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-clients-phones', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('get-transport', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-transport', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-transport', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-transport', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-transport', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('get-transport-about', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-transport-about', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-transport-about', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-transport-about', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-transport-about', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('get-transport-perhaps', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-transport-perhaps', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-transport-perhaps', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-transport-perhaps', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-transport-perhaps', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('get-transport-position', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-transport-position', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-transport-position', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-transport-position', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-transport-position', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('get-transport-state', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-transport-state', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-transport-state', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-transport-state', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-transport-state', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('get-trips', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-trips', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-trips', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-trips', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-trips', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('get-trips-children', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-trips-children', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-trips-children', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-trips-children', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-trips-children', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('get-trips-perhaps', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-trips-perhaps', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-trips-perhaps', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-trips-perhaps', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-trips-perhaps', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('get-trips-transport', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-trips-transport', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-trips-transport', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-trips-transport', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-trips-transport', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        //

        Gate::define('get-routes', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-routes', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-routes', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-routes', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-routes', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        Gate::define('get-users', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('search-users', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('delete-users', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-users', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('create-users', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });

        Gate::define('edit-city', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-country', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
        Gate::define('edit-region', function ($user) {
             $privilege=app("App\Http\Controllers\Users\Privileges")->get();
             return $privilege>=6;
        });
    }
}
