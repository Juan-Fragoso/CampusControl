<?php

namespace App\Http\Controllers;

use App\Models\CourseAssignment;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Group;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseAssignmentController extends Controller
{
    public function index()
    {
        $courseAssignments = CourseAssignment::with(['subject', 'teacher'])->get();
        $teachers = Teacher::with('user')->get();
        $subjects = Subject::all();
        $groups = Group::all();

        return view('admins.index-course-assignment', compact('courseAssignments', 'teachers', 'subjects', 'groups'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'teacher_id'=> 'required',
            'subject_id'=> 'required',
            'group_id'=> 'required',
        ]);

        try {
            DB::beginTransaction();

            $course = CourseAssignment::updateOrInsert([
                'subject_id'=> $request->subject_id,
                'teacher_id'=> $request->teacher_id,
                'group_id'=> $request->teacher_id
            ]);

            DB::commit();

            return redirect()->route('course-assignments')->with('success','Asignación Registrado');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getGroupsSubjects(Request $request)
    {
        $authUser = Auth::user();

        if($authUser->teacher && !isset($authUser->student)) {
            $courseAssignments = CourseAssignment::where(['teacher_id' => $authUser->teacher->id])->get();
        } else if(!isset($authUser->student) && !isset($authUser->teacher)) {
            $courseAssignments = CourseAssignment::all();
        }

        return view('admins.my-course-assignments', compact('courseAssignments'));
    }

    public function getStudentsGroupSubject(Request $request, $groupId, $subjectId)
    {
        $boleta = $request->boleta; // Capturamos lo que viene del buscador
        $student = null;
        $enrollment = null;
        $grade = null;

        if ($boleta) {
            // 1. Buscamos al estudiante por su Folio/Boleta
            $student = Student::where('boleta', $boleta)->first();

            if ($student) {
                // 2. Verificamos que el alumno esté inscrito EN ESTE GRUPO
                $enrollment = Enrollment::where('student_id', $student->id)
                                        ->where('group_id', $groupId)
                                        ->first();

                if ($enrollment) {
                    // 3. Buscamos si ya tiene una calificación guardada
                    $grade = Grade::where('enrollment_id', $enrollment->id)
                                ->where('subject_id', $subjectId)
                                ->first();
                }
            }
        }

        return view('admins.course-assignments', [
            'groupId' => $groupId,
            'subjectId' => $subjectId,
            'student' => $student,
            'enrollment' => $enrollment,
            'grade' => $grade,
            'boleta' => $boleta
        ]);
    }
}
