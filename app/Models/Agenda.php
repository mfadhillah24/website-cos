<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'type', 'agenda_date', 'end_date', 'start_time', 'end_time',
        'location', 'pic', 'participants', 'description', 'status', 'created_by',
    ];

    protected $casts = [
        'agenda_date' => 'date',
        'end_date'    => 'date',
    ];

    /**
     * Apakah agenda berlangsung lebih dari 1 hari?
     */
    public function isMultiDay(): bool
    {
        return $this->end_date && $this->end_date->gt($this->agenda_date);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
