<?php

namespace App\Http\Controllers;

use App\Models\CourseAssignment;
use App\Models\Group;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
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
}
