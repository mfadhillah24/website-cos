<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RabItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'rab_id',
        'description',
        'quantity',
        'unit',
        'unit_price',
        'subtotal',
    ];

    public function rab()
    {
        return $this->belongsTo(Rab::class);
    }
}
