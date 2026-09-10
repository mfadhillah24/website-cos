<?php

namespace App\Providers;

use App\Models\Member;
use App\Policies\KabidMemberPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Super Admin bypasses all Gate/authorize() checks
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Super Admin')) {
                return true;
            }
        });

        // Policy: KABID hanya dapat melihat anggota di bidangnya sendiri
        Gate::policy(Member::class, KabidMemberPolicy::class);
    }
}

