<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Letter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type', 'letter_number', 'letter_date', 'subject', 'letter_type',
        'priority', 'summary', 'file_path',
        'received_date', 'sender', 'agenda_number', 'destination',
        'receiver', 'signer', 'signer_position',
        'status', 'previous_status', 'notes', 'created_by',
    ];

    protected $casts = [
        'letter_date'   => 'date',
        'received_date' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function dispositions()
    {
        return $this->hasMany(Disposition::class);
    }
}
