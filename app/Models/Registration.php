<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nim',
        'study_program',
        'batch_year',
        'email',
        'phone',
        'birth_place',
        'birth_date',
        'address',
        'division_id',
        'reason',
        'photo',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
