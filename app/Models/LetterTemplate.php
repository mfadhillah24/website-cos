<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class LetterTemplate extends Model {
    use HasFactory;
    protected $fillable = ['name','description','content','file_path','file_name','file_extension','mime_type','file_size','created_by'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
