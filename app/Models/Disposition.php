<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disposition extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_id', 'user_id', 'instruction', 'notes',
        'disposition_date', 'deadline', 'status', 'created_by',
    ];

    protected $casts = [
        'disposition_date' => 'date',
        'deadline'         => 'date',
    ];

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
