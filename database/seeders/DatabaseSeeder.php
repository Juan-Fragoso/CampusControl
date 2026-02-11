<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Role;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createRoles();
        $this->createSubject();
        $this->createGroups();
        $this->createUsers();
    }

    public function createRoles()
    {
        Role::create(["name"=> "admin", "description" => "Administrador del sistema"]);
        Role::create(["name"=> "student", "description" => "Cliente del sistema"]);
        Role::create(["name"=> "teacher", "description" => "Docente del sistema"]);
    }

    public function createSubject()
    {
        Subject::create(["code" => "MAT", "name" => "Matemáticas"]);
        Subject::create(["code" => "LEN", "name" => "Lengua y Literatura"]);
        Subject::create(["code" => "SOC", "name" => "Ciencias Sociales"]);
        Subject::create(["code" => "NAT", "name" => "Ciencias Naturales"]);
        Subject::create(["code" => "FIS", "name" => "Educación Física"]);
    }

    public function createGroups()
    {
        Group::create(["name" => "Grupo A", "period" => "2026-1"]);
        Group::create(["name" => "Grupo B", "period" => "2026-1"]);
        Group::create(["name" => "Grupo C", "period" => "2026-1"]);
        Group::create(["name" => "Grupo D", "period" => "2026-1"]);
        Group::create(["name" => "Grupo E", "period" => "2026-1"]);
    }

    public function createUsers()
    {
        $user = User::create([
            "name" => "Administrador",
            "email" => "admin@campuscontrol.com",
            "password" => bcrypt("admin123"),
        ]);

        $teacherUser = User::create([
            "name" => "Profesor",
            "email" => "profesor@campuscontrol.com",
            "password" => bcrypt("profesor123"),
        ]);

        $teacher = Teacher::create([
            "user_id" => $teacherUser->id,
            "phone" => "0987654321",
            "employee_number" => "EMP12345",
        ]);

        $studentUser = User::create([
            "name" => "Estudiante",
            "password" => bcrypt("estudiante123"),
            "email" => "estudiante@campuscontrol.com",
        ]);

        $student = Student::create([
            "user_id" => $studentUser->id,
            "phone" => "1234567890",
            "boleta" => "20260005",
        ]);
    }
}
