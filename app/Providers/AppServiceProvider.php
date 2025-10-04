<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Comment; 
use Illuminate\Auth\Access\Response;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrap();
        Gate::before(function(User $user){
            if ($user->role == "moderator")
                return true;
        });

        Gate::define('comment', function(User $user, Comment $comment){
            return ($user->id == $comment->user_id) 
            ? Response::allow()
            : Response::deny('Your don`t moderator');
        });
    }
}
