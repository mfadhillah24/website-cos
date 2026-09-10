<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MeetingMinute extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id', 'leader', 'notulist', 'discussion_results',
        'decisions', 'follow_up', 'follow_up_deadline', 'attachment_path', 'created_by',
    ];

    protected $casts = [
        'follow_up_deadline' => 'date',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
