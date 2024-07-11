<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $table = 'exams';
    protected $fillable = ['name', 'time', 'admin_id'];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'exam_id');
    }
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    // public function student()
    // {
    //     return $this->belongsToMany(student::class);
    // }
}
