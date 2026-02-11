<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $fillable = ["phone", "boleta", "user_id"];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrollments()
    {
        // Un alumno tiene muchas inscripciones a grupos
        return $this->hasMany(Enrollment::class);
    }
}

