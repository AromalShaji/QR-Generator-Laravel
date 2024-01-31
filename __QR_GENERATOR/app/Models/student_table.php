<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_table extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $fillable = [
        'prn', 'student_name', 'false_number', 'college_id', 'course_id', 'exam_id',
    ];
    public function college(){
        return $this->belongsTo(College::class, 'college_id');
    }
    public function exam(){
        return $this->belongsTo(Exam::class, 'exam_id');
    }
}
