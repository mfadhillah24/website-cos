<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'path',
        'caption',
        'order',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
