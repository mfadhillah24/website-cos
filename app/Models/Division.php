<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'cover_image',
        'focus_areas',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'focus_areas' => 'array',
    ];

    public function divisionMembers()
    {
        return $this->hasMany(DivisionMember::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function reports()
    {
        return $this->hasMany(DivisionReport::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }
}
