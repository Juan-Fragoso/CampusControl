<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_users';
    protected $primaryKey = 'id';
    protected $fillable = ["user_id", "role_id", "group_id"];
}
