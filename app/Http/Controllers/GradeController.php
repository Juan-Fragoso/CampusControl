<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function save(Request $request)
    {
       // 1. Validación de datos
        $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'subject_id'    => 'required|exists:subjects,id',
            'teacher_id'    => 'required|exists:teachers,id',
            'grade_value'   => 'required|numeric|min:0|max:10',
        ]);

        try {
            // 2. Guardar o Actualizar la calificación
            // Buscamos por enrollment y subject; si existe actualiza el valor, si no lo crea.
            Grade::updateOrCreate(
                [
                    'enrollment_id' => $request->enrollment_id,
                    'subject_id'    => $request->subject_id,
                ],
                [
                    'teacher_id'    => $request->teacher_id,
                    'grade_value'   => $request->grade_value,
                ]
            );

            // 3. Redireccionar con el componente de alerta que creamos
            return redirect()->back()->with('success', 'La calificación se ha registrado correctamente.');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Error al guardar: ' . $th->getMessage());
        }
    }
}
