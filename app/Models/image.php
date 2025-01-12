<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'title', 'subjectName', 'exam_id', 'admin_id']; // اسم الحقل المرتبط بالامتحان

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function admin()
    {
        return $this->belongsTo(Image::class, 'admin_id');
    }
}
