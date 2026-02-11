<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseAssignment extends Model
{
    protected $table = 'course_assignments';
    protected $primaryKey = 'id';
    protected $fillable = ["teacher_id", "subject_id", "group_id"];

    public function teacher() { return $this->belongsTo(Teacher::class); }
    public function subject() { return $this->belongsTo(Subject::class); }
    public function group()   { return $this->belongsTo(Group::class); }
}
