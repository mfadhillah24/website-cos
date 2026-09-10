<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'division_id',
        'period_id',
        'program_id',
        'title',
        'slug',
        'description',
        'content',
        'thumbnail',
        'start_date',
        'end_date',
        'location',
        'status',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($activity) {
            if (empty($activity->slug)) {
                $activity->slug = Str::slug($activity->title) . '-' . time();
            }
        });
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function photos()
    {
        return $this->hasMany(ActivityPhoto::class)->orderBy('order');
    }

    public function galleryPhotos()
    {
        return $this->hasMany(GalleryPhoto::class);
    }
}
