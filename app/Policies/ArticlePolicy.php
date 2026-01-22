<?php

namespace App\Policies;

use App\Enums\ArticleStatus;
use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Article $article): bool
    {
        if ($user->role === 'admin' || $user->role === 'editor') return true;
        return $user->id === $article->author_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Article $article): bool
    {
        if ($user->role === 'admin') return true;

        if ($user->role === 'editor') {
            return in_array($article->status, [
                ArticleStatus::PENDING_REVIEW,
                ArticleStatus::PUBLISH
            ]);
        }

        return $user->id === $article->author_id && in_array($article->status, [
            ArticleStatus::DRAF,
            ArticleStatus::CHANGES_REQUESTED
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
        if ($user->role === 'admin') return true;

        return $user->id === $article->author_id && $article->status === ArticleStatus::DRAF;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Article $article): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Article $article): bool
    {
        return false;
    }
}
