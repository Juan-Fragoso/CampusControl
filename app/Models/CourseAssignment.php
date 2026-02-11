<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseAssignment extends Model
{
    protected $table = 'course_assignments';
    protected $primaryKey = 'id';
    protected $fillable = ["teacher_id", "subject_id", "group_id"];
}
