<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
class StudentController extends Controller
{
     public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:student,student_id',
            'email_address' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
            'password' => 'required',
            'username' => 'required',
            'age' => 'required|integer',
            'date_of_birth' => 'required|date',
            'gender' => 'required'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        Student::create($validated);

        return response()->json(['success' => true]);
    }
}
