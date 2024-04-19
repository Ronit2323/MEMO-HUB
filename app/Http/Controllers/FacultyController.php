<?php

namespace App\Http\Controllers;

use App\Models\faculty;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check if the request has a 'first_letter' parameter
        if ($request->has('first_letter')) {
            // Retrieve the first letter typed by the user from the request
            $firstLetter = $request->input('first_letter');
    
            // Perform a search query to find faculties whose names start with the specified first letter
            $faculties = Faculty::where('faculty_name', 'like', $firstLetter . '%')->paginate(7);
        } else {
            // If no search parameter is provided, retrieve all faculties
            $faculties = Faculty::paginate(7);
        }
    
        // Pass the faculties to the view
        return view('faculty.index', compact('faculties'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('faculty.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'faculty_name'
            ]

        );
        $faculty = new faculty();
        $faculty->faculty_name = $request->faculty_name;
        $faculty->save();
        Alert::success('The Faculty is added successfully');

        return redirect()->route('facultys.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(faculty $faculty)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(faculty $faculty)
    {
        return view('faculty.edit', compact('faculty'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, faculty $faculty)
    {
        $request->validate([
            'faculty_name'

        ]);
        $faculty->faculty_name = $request->faculty_name;
        $faculty->update();
        return redirect()->route('facultys.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(faculty $faculty)
    {
        $faculty->delete();
        return redirect()->route('facultys.index');
    }
}
