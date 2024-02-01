<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exam extends Model
{
    use HasFactory;
    protected $table = 'exams';
    protected $fillable = ['exam_name', 'subject_name'];
    public function students(){
        return $this->hasMany(Student::class, 'exam_id');
    }
}
