<?php

namespace App\Policies;

use App\Models\Learners;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LearnersPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isUser();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Learners $learners): bool
    {
        return $user->isAdmin() || $user->isUser();
    }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create(User $user): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can update the model.
    //  */
    // public function update(User $user, Learners $learners): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Learners $learners): bool
    {
        return $user->isAdmin() || $user->isUser();
    }

      /**
     * Determine whether the user can delete the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Learners $learners): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Learners $learners): bool
    {
        return $user->isAdmin();
    }

       /**
     * Determine whether the user can Bulk restore the models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can Bulk permanently delete the models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
