<?php

namespace App\Providers;


use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];


    public function boot()
    {
        $this->registerPolicies();

        Gate::define('author-post-actions', function (User $user, Model $model) {
//            dd($post);
            return $user->id === $model->author_id
                ? Response::allow()
                : Response::denyWithStatus(\Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED);
        });
    }
}
