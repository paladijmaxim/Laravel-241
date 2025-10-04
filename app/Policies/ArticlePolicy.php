<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Article $article): bool
    {
        //
    }

    public function create(User $user)
    {
        return ($user->role == "moderator")
            ? Response::allow()
            : Response::deny("Your don`t moderator");
    }

    public function update(User $user, Article $article)
    {
        return ($user->id == $article->users_id)
            ? Response::allow()
            : Response::deny("Your don`t moderator");
    }

    public function delete(User $user, Article $article)
    {
            return ($user->role == "moderator")
                ? Response::allow()
                : Response::deny("Your don`t moderator");
    }

    public function restore(User $user, Article $article)
    {
            return ($user->id == $article->users_id)
                ? Response::allow()
                : Response::deny("Your don`t moderator");
    }

    public function forceDelete(User $user, Article $article)
    {
            return ($user->id == $article->users_id)
                ? Response::allow()
                : Response::deny("Your don`t moderator");
    }
}