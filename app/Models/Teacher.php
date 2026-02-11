<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $fillable = ["phone", "employee_number", "user_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courseAssignments()
    {
        // Las materias y grupos que tiene asignados para dar clase
        return $this->hasMany(CourseAssignment::class);
    }
}
