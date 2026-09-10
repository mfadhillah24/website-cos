<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisionReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'division_id',
        'period_id',
        'author_id',
        'title',
        'activity_date',
        'activity_type',
        'content',
        'status',
        'submitted_at',
        'approved_at',
    ];

    protected $casts = [
        'submitted_at'  => 'datetime',
        'approved_at'   => 'datetime',
        'activity_date' => 'date',
    ];

    public function activityTypeLabel(): string
    {
        return match($this->activity_type) {
            'pembelajaran'  => 'Kegiatan Pembelajaran',
            'program_kerja' => 'Program Kerja',
            'rapat'         => 'Rapat',
            default         => 'Lainnya',
        };
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function reviews()
    {
        return $this->hasMany(ReportReview::class, 'report_id');
    }

    public function photos()
    {
        return $this->hasMany(ReportPhoto::class, 'report_id');
    }

    public function latestReview()
    {
        return $this->hasOne(ReportReview::class, 'report_id')->latestOfMany();
    }

    public function isEditable(): bool
    {
        return in_array($this->status, ['draft', 'revision']);
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'draft'     => 'Draft',
            'submitted' => 'Diajukan',
            'reviewing' => 'Sedang Direview',
            'revision'  => 'Perlu Revisi',
            'approved'  => 'Disetujui',
            default     => ucfirst($this->status),
        };
    }

    public function statusBadge(): string
    {
        return match($this->status) {
            'draft'     => 'badge-gray',
            'submitted' => 'badge-blue',
            'reviewing' => 'badge-blue',
            'revision'  => 'badge-orange',
            'approved'  => 'badge-green',
            default     => 'badge-gray',
        };
    }
}
