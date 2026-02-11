<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grades';
    protected $primaryKey = 'id';
    protected $fillable = ["enrollment_id", "subject_id", "teacher_id", "grade_value", "term"];
}
