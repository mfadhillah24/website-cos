<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    use HasFactory;

    protected $table = 'managements';

    protected $fillable = [
        'member_id',
        'period_id',
        'position_id',
        'user_id',
        'is_active',
        'started_at',
        'ended_at',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'started_at' => 'date',
        'ended_at' => 'date',
    ];

    // ─── Relationships ───────────────────────────────

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Scopes ───────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
