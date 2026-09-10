<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'meeting_date', 'start_time', 'end_time',
        'location', 'agenda', 'attendance_count', 'participants', 'status', 'created_by',
    ];

    protected $casts = [
        'meeting_date' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function minute()
    {
        return $this->hasOne(MeetingMinute::class);
    }
}
