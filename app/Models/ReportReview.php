<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'reviewer_id',
        'notes',
        'action',
    ];

    public function report()
    {
        return $this->belongsTo(DivisionReport::class, 'report_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
