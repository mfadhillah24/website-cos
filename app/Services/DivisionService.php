<?php

namespace App\Services;

use App\Models\Division;
use Illuminate\Support\Str;

class DivisionService
{
    /**
     * Create a new division.
     */
    public function createDivision(array $data): Division
    {
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $data['is_active'] ?? true;
        
        return Division::create($data);
    }

    /**
     * Update an existing division.
     */
    public function updateDivision(Division $division, array $data): Division
    {
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $division->update($data);
        return $division;
    }

    /**
     * Delete a division.
     */
    public function deleteDivision(Division $division): bool
    {
        return $division->delete();
    }
}
