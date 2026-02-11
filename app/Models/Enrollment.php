<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'enrollments';
    protected $primaryKey = 'id';
    protected $fillable = ["student_id", "group_id", "status"];


    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function group()   { return $this->belongsTo(Group::class); }
    public function grades()  { return $this->hasMany(Grade::class); }
}
