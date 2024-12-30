<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employment\AddEmploymentRequest;
use App\Models\Employment;
use Illuminate\Http\Request;

class EmploymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employments = Employment::whereUserId(session('user_id'))->get();
        return view('employees.index', compact('employments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddEmploymentRequest $request)
    {
        $employements = $request->input('employment');
        foreach ($employements as $employement) {
            $data = array_merge([
                'user_id' => session('user_id')
            ], $employement);
            Employment::create($data);
        }
        return response()->json(['message' => 'Employment added successfully!'], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employment $employment)
    {
        return view('employees.edit' , compact('employment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddEmploymentRequest $request, Employment $employment)
    {
        $employment->update([
            'employer_name' => $request->input('employer_name'),
            'position' =>  $request->input('position'),
            'occupation' => $request->input('occupation'),
            'manager_name' => $request->input('manager_name'),
            'manager_email' => $request->input('manager_email'),
        ]);

        return response()->json([
            'data' => $employment,
            'message' => 'Employment updated'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employment $employement)
    {
        $employement->delete();
        return response()->json([
            'message' => 'Employment deleted'
        ]);
    }
}
