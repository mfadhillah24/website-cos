<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'division_id',
        'period_id',
        'role_in_division',
        'joined_at',
        'left_at',
    ];

    protected $casts = [
        'joined_at' => 'date',
        'left_at' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
