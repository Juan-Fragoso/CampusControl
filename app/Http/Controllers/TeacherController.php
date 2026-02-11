<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function saveUpdate(Request $request)
    {
        // Buscamos si existe el maestro, si no, creamos una instancia vacía
        $teacher = $request->id ? Teacher::find($request->id) : new Teacher;
        $user = $teacher->user ?? new User;

        // 2. Validar (Ignorando el ID actual en campos únicos)
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email," . ($user->id ?? 'NULL'),
            "employee_number" => "required|string|unique:teachers,employee_number," . ($teacher->id ?? 'NULL'),
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

            // 4. Guardar/Actualizar Perfil de Maestro
            $teacher->phone = $request->phone;
            $teacher->employee_number = $request->employee_number;
            $teacher->user_id = $user->id;
            $teacher->save();

            // 5. Asignar rol solo si es nuevo
            if (!$request->id) {
                $teacherRole = Role::where('name', 'teacher')->first();
                if ($teacherRole) {
                    $user->roles()->attach($teacherRole->id);
                }
            }

            DB::commit();

            return redirect()->route("teachers")->with("success", $request->id ? "Actualizado" : "Creado");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with("error", "Error al actualizar: " . $th->getMessage());
        }
        return redirect()->route('teachers');
    }

    public function edit($id)
    {
        $teacher = Teacher::find($id);
        return view('teachers.create', compact('teacher'));
    }
}
