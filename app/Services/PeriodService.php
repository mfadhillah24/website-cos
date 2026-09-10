<?php

namespace App\Services;

use App\Models\Period;
use Illuminate\Support\Facades\DB;

class PeriodService
{
    /**
     * Create a new period.
     */
    public function createPeriod(array $data): Period
    {
        return DB::transaction(function () use ($data) {
            // If the new period is active, deactivate other periods (optional based on business logic, but usually good)
            if (!empty($data['is_active'])) {
                Period::where('is_active', true)->update(['is_active' => false]);
            }

            return Period::create($data);
        });
    }

    /**
     * Update an existing period.
     */
    public function updatePeriod(Period $period, array $data): Period
    {
        return DB::transaction(function () use ($period, $data) {
            // If making active, deactivate others
            if (!empty($data['is_active']) && !$period->is_active) {
                Period::where('id', '!=', $period->id)->where('is_active', true)->update(['is_active' => false]);
            }

            $period->update($data);
            return $period;
        });
    }

    /**
     * Close an active period.
     */
    public function closePeriod(Period $period, int $userId): Period
    {
        return DB::transaction(function () use ($period, $userId) {
            $period->update([
                'is_active' => false,
                'closed_at' => now(),
                'closed_by' => $userId,
            ]);

            // Demisioner logic
            $period->managements()->update([
                'is_active' => false,
                'ended_at' => now()->toDateString(),
            ]);

            return $period;
        });
    }
}
