<?php

namespace App\Http\Controllers;

use App\Models\student;
use Illuminate\Http\Request;

class studentController extends Controller
{
    //

    public function index()
    {
        return view('student.view');
    }
   
    public function view()
    {
        $student = student::all();
        return response()->json($student);  // Return students in JSON format
    }
      

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'class' => 'required',
        ]);

        $student = new student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->class = $request->class;
        $student->save();

       return response()->json($student);
    }
}
