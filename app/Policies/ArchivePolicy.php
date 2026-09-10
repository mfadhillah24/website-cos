<?php

namespace App\Policies;

use App\Models\Archive;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArchivePolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Any user can view the archive list (controller will filter based on visibility)
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Archive $archive): bool
    {
        if ($user->hasPermissionTo('manage_archives')) {
            return true; // Secretary/Admin
        }

        if ($user->hasRole('Ketua Umum')) {
            return true; // Ketua can view all
        }

        if ($archive->visibility === 'public' || $archive->visibility === 'internal') {
            return true; // Any authenticated member can view internal/public
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage_archives');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Archive $archive): bool
    {
        if (!$user->hasPermissionTo('manage_archives')) {
            return false;
        }

        // Cannot update if period is closed (unless Super Admin, handled by before())
        if ($archive->period && !$archive->period->is_active) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Archive $archive): bool
    {
        if (!$user->hasPermissionTo('manage_archives')) {
            return false;
        }

        if ($archive->period && !$archive->period->is_active) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Archive $archive): bool
    {
        return $user->hasPermissionTo('manage_archives');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Archive $archive): bool
    {
        return $user->hasRole('Super Admin'); // Only Super Admin can hard delete
    }
}
