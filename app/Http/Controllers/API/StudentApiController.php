<?php

namespace App\Http\Controllers\API;

use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator; // Correct import
use Illuminate\Http\Request;

class StudentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Show all students
        $students = Student::all();
        return response()->json($students, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Store a new student

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email', // Ensure email is unique        
            'gender' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        Student::create($data);
        return response()->json([
            "status" => "success",
            "message" => "Student created successfully",
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Show a specific student
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                "status" => "error",
                "message" => "Student not found"
            ], 404);
        } else {
            return response()->json($student, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Update a specific student
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                "status" => "error",
                "message" => "Student not found"
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:students,email,' . $id, // Ensure email is unique except for current student    
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()
            ], 422);
        }
        $data = $validator->validated();
        $student->update($data);
        return response()->json([
            "status" => "success",
            "message" => "Student updated successfully",
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete a specific student
        $student = Student::find($id);
        if (!$student) {
            return response()->json([
                "status" => "error",
                "message" => "Student not found"
            ], 404);
        } // <-- Add this closing brace

        $student->delete();
        return response()->json([
            "status" => "success",
            "message" => "Student deleted successfully",
        ], 200);
    }
}
