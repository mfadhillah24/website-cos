<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Finance extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'category_id',
        'date',
        'description',
        'amount',
        'type',
        'receipt_path',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function category()
    {
        return $this->belongsTo(FinanceCategory::class, 'category_id');
    }
}
