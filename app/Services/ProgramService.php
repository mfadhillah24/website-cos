<?php

namespace App\Services;

use App\Models\Program;
use App\Models\Period;
use Illuminate\Support\Facades\Auth;

class ProgramService
{
    /**
     * Create a new program.
     */
    public function createProgram(array $data): Program
    {
        $activePeriod = Period::where('is_active', true)->first();
        if ($activePeriod) {
            $data['period_id'] = $activePeriod->id;
        }

        $data['created_by'] = Auth::id();
        
        return Program::create($data);
    }

    /**
     * Update an existing program.
     */
    public function updateProgram(Program $program, array $data): Program
    {
        $program->update($data);
        return $program;
    }

    /**
     * Delete a program.
     */
    public function deleteProgram(Program $program): bool
    {
        return $program->delete();
    }
}
