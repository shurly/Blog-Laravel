<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Post;
use App\Policies\PostPoslicy;
use App\Models\Permission;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPoslicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('owner', function (User $user, $data){
            return $user->id == $data->user_id;
        });

        Gate::define('update_profile', function (User $user, $id){
            return $user->id == $id;
        });

        $permissions = Permission::all();
        foreach ($permissions as $permission){
            Gate::define($permission->name, function (User $user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }

        Gate::before(function (User $user, $ability)
        {
            if($user->hasProfile('Admin'))
                return true;
        });
    }



}
