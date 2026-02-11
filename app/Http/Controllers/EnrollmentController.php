<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::all();
        $students = Student::all();
        $groups = Group::all();

        return view("admins.enrollments" , compact("enrollments", "students", "groups"));
    }

    public function saveUpdate(Request $request)
    {
        $request->validate([
            "student_id" => "required",
            "group_id" => "required",
        ]);

        try {
            DB::beginTransaction();

            Enrollment::updateOrCreate([
                "student_id"=> $request->student_id,
                "group_id"=> $request->group_id,
                "status"=> 'active',
            ]);

            DB::commit();

            return redirect()->route("enrollments")->with("success","Inscripción Registrada");

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->with("error", "Error: " . $th->getMessage());
        }
    }

}
