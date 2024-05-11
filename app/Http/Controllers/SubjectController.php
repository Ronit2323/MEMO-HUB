<?php

namespace App\Http\Controllers;

use App\Models\subject;
use App\Models\faculty;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SubjectController extends Controller
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
    
            // Perform a search query to find subjects whose names start with the specified first letter
            $subjects = Subject::where('subject_name', 'like', $firstLetter . '%')->paginate(7);
        } else {
            // If no search parameter is provided, retrieve all subjects
            $subjects = Subject::paginate(7);
        }
    
        // Pass the subjects to the view
        return view('subject.index', compact('subjects'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subject.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'subject_name'
            ]

        );
        $subject = new subject();
        $subject->subject_name = $request->subject_name;
        $subject->save();
        Alert::success('The subject is added successfully');
        return redirect()->route('subjects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(subject $subject)
    {
        return view('subject.edit', compact('subject')); // method retrieves a specific Subject object from the database based on its ID, and then passes that object to a view for editing. T
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, subject $subject)
    {
        $request->validate([
            'subject_name'

        ]);
        $subject->subject_name = $request->subject_name;
        $subject->update();
        return redirect()->route('subjects.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index');
    }
    public function showAssociateForm()
    {
        $subjects = Subject::all();
        $faculties = Faculty::all();

        return view('admin.associate', compact('subjects', 'faculties'));
    }
    public function associateWithFaculty(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'faculty_id' => 'required|exists:faculties,id',
        ]);

        // Assuming you have a pivot table named 'faculty_subject' to store the associations
        $subject = Subject::find($request->subject_id);
        $faculty = Faculty::find($request->faculty_id);

        // Attach the subject to the faculty
        $faculty->subjects()->attach($subject);

        // Optionally, you can redirect back with a success message
        // return redirect()->back()->with('success', 'Subject associated with Faculty successfully.');
        Alert::success('Association betweeen the subject and faculty is successfully');
        return redirect()->route('association');
    }
}
