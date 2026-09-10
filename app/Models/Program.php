<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'division_id',
        'period_id',
        'title',
        'description',
        'target',
        'status',
        'pic_member_id',
        'created_by',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function pic()
    {
        return $this->belongsTo(Member::class, 'pic_member_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
