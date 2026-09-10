<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'status_id',
        'nim',
        'nta',
        'name',
        'email',
        'phone',
        'photo',
        'angkatan',
        'generation',
        'bio',
        'linkedin',
        'github',
        'is_founder'
    ];

    protected $casts = [
        'is_founder' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(MemberStatus::class, 'status_id');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(MemberStatusHistory::class);
    }

    public function managements(): HasMany
    {
        return $this->hasMany(Management::class);
    }

    public function divisionMembers(): HasMany
    {
        return $this->hasMany(DivisionMember::class);
    }

    public function primaryDivision()
    {
        // Mendapatkan division aktif berdasarkan period saat ini
        return $this->hasOne(DivisionMember::class)
            ->whereHas('period', function($q) {
                $q->where('is_active', true);
            })
            ->latestOfMany('joined_at');
    }
}
