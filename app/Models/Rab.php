<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rab extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'activity_name',
        'period_id',
        'date',
        'pic_name',
        'pic_position',
        'description',
        'status',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function items()
    {
        return $this->hasMany(RabItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTotalAttribute()
    {
        return $this->items->sum('subtotal');
    }
}
