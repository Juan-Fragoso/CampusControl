<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $fillable = ["full_name", "phone", "employee_number", "user_id"];
}
