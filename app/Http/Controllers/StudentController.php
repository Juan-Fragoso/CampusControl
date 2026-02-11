<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view("students.students", compact("students"));
    }

    public function create()
    {
        return view("students.create");
    }

    public function edit(Request $request)
    {
        $student = Student::find($request->id);
        return view("students.create", compact("student"));
    }

    public function saveUpdate(Request $request)
    {
        // Buscamos si existe el estudiante, si no, creamos una instancia vacía
        $student = $request->id ? Student::find($request->id) : new Student;
        $user = $student->user ?? new User;

        // 2. Validar (Ignorando el ID actual en campos únicos)
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email," . ($user->id ?? 'NULL'),
            "boleta" => "required|string|unique:students,boleta," . ($student->id ?? 'NULL'),
            "phone" => "nullable|string|max:20",
            "password" => $request->id ? "nullable|string|min:8" : "required|string|min:8",
        ]);

        try {
            DB::beginTransaction();

            // 3. Actualizar datos del Usuario
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }

            $user->save();

            // 4. Guardar/Actualizar Perfil de Estudiante
            $student->phone = $request->phone;
            $student->boleta = $request->boleta;
            $student->user_id = $user->id;
            $student->save();

            // 5. Asignar rol solo si es nuevo
            if (!$request->id) {
                $studentRole = Role::where('name', 'student')->first();
                if ($studentRole) {
                    $user->roles()->attach($studentRole->id);
                }
            }

            DB::commit();

            return redirect()->route("students")->with("success", $request->id ? "Actualizado" : "Creado");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with("error", "Error al actualizar: " . $th->getMessage());
        }
    }
}
