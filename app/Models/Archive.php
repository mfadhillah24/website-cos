<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Archive extends Model {
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name', 'category', 'period_id', 'activity_id', 
        'document_number', 'document_date', 'description', 
        'file_path', 'status', 'visibility', 'uploaded_by'
    ];
    
    protected $casts = [
        'document_date' => 'date'
    ];
    
    public function uploader() { 
        return $this->belongsTo(User::class, 'uploaded_by'); 
    }
    
    public function period() {
        return $this->belongsTo(Period::class);
    }
    
    public function activity() {
        return $this->belongsTo(Activity::class);
    }
}

