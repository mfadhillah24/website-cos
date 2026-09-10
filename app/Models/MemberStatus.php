<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MemberStatus extends Model
{
    protected $fillable = ['name', 'description'];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'status_id');
    }

    public function historiesFrom(): HasMany
    {
        return $this->hasMany(MemberStatusHistory::class, 'from_status_id');
    }

    public function historiesTo(): HasMany
    {
        return $this->hasMany(MemberStatusHistory::class, 'to_status_id');
    }
}
