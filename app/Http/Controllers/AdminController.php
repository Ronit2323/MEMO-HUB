<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Moderator;
use App\Models\Subject;
use App\Models\Note;
use App\Models\Faculty;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\demomail;
use Illuminate\Support\Facades\Mail;


class AdminController extends Controller
{
    public function index()
    {
        // Total number of users except admin
        $totalUsers = User::count();

        // Total number of moderators
        $totalModerators = Moderator::count();

        // Total number of subjects
        $totalSubjects = Subject::count();

        // Total notes uploaded
        $totalNotesUploaded = Note::count();

        // Total number of subjects and faculties
        $totalSubjects = Subject::count();
        $totalFaculties = Faculty::count();

        // Total number of comments
        $totalComments = Comment::count();
        $mostPopularFaculty = DB::table('notes')
            ->join('faculties', 'notes.faculty_id', '=', 'faculties.id')
            ->select('faculties.faculty_name', DB::raw('COUNT(notes.id) as note_count'))
            ->groupBy('faculties.faculty_name')
            ->orderBy('note_count', 'desc')
            ->first();

        // Most popular subject note uploaded
        $mostPopularSubject = DB::table('notes')
            ->join('subjects', 'notes.subject_id', '=', 'subjects.id')
            ->select('subjects.subject_name', DB::raw('COUNT(notes.id) as note_count'))
            ->groupBy('subjects.subject_name')
            ->orderBy('note_count', 'desc')
            ->first();

        return view('admin.dashboard', compact('totalUsers', 'totalModerators', 'totalSubjects', 'totalNotesUploaded', 'totalSubjects', 'totalFaculties', 'totalComments', 'mostPopularFaculty', 'mostPopularSubject'));
    }

    public function getUser()
    {
        $user = user::all();
        return view('admin.email', compact('user'));
    }
    public function sendMail($id)
    {
        $data = user::find($id);
        return view('admin.sendMail', compact('data'));
    }
    public function sendEmail(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
        ]);

        // Find user
        $user = User::find($id);

        // Send email with form input values
        Mail::to($user->email)->send(new demomail($request->title, $request->message));

        // Redirect back with success message
        return redirect()->back()->with('success', 'Email sent successfully!');
    }
}
