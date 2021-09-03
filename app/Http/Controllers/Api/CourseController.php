<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function courseRegistration(Request $request)
    {
    $request->validate([
        "title" => "required",
        "description" => "required",
        "instructor" => "required"
    ]);

    $course = new Course();
    $course->user_id = auth()->user()->id;
    $course->title = $request->title;
    $course->description = $request->description;
    $course->Instructor = $request->Instructor;

    $course->save();

    return response()->json([
        "status" => 1,
        "message" => "Course Registered Successfully"
    ]);
    }

    public function totalCourses()
    {
        $id = auth()->user()->id;

        $courses = User::find($id)->courses;

        return response()->json([
            "status" => 1,
            "message" => "Total Courses Registered",
            "data" => $courses

        ]);


    }

    public function deleteCourse($id)
    {
        $user_id = auth()->user()->id;
    if (Course::where([
        "id" => $id,
        "user_id" => $user_id
    ])->exists()) {
        $course = Course::find($id);
        $course->delete();
        return response()->json([
            "status" => 1,
            "message" => "Course deleted successfully"
        ]);
   

    } else {
        return response()->json([
            "status" => 0,
            "message" => "Course not found"
        ]);
     
    }
    }
}
