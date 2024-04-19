<?php

namespace App\Http\Controllers;

use App\Events\UserStatus;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\note;
use App\Models\Subject;
use App\Models\faculty;
use App\Models\Moderator;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

use Khill\Lavacharts\Lavacharts;

use Illuminate\Support\Facades\DB;
use App\Notifications\NewReviewNotification;


class moderatorController extends Controller
{
    public function index(Request $request)
    {
        // Check if the request has a 'first_letter' parameter (indicating a search)
        if ($request->has('first_letter')) {
            $firstLetter = $request->input('first_letter');
            // Perform the search based on the first letter
            $users = User::where('name', 'like', $firstLetter . '%')->paginate(7);
        } else {
            // If no search parameter is provided, retrieve all users
            $users = User::paginate(7);
        }

        // Pass the users to the view
        return view('moderator.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('moderatorIndex')->with('error', 'User not found');
        }

        $subjects = Subject::all();
        $faculties = Faculty::all();

        return view('moderator.edit', compact('user', 'subjects', 'faculties'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'faculty_id' => 'required|exists:faculties,id',
            'user_type' => 'required|in:moderator',
            // Add other validation rules as needed
        ]);

        // Find or create the Moderator record for the user
        $moderator = Moderator::updateOrCreate(
            ['user_id' => $id],
            [
                'subject_id' => $request->input('subject_id'),
                'faculty_id' => $request->input('faculty_id'),
            ]
        );

        // Update the user type in the users table
        $user = User::findOrFail($id);
        $user->update(['userType' => $request->input('user_type')]);
        Alert::success('succesfully updated moderator');
        return redirect()->route('viewUser', ['id' => $id]);
    }

    public function getSubjects($faculty_id)
    {
        $faculty = Faculty::findOrFail($faculty_id);
        $subjects = $faculty->subjects;

        return response()->json($subjects);
    }
    public function viewNotes($moderatorId)
    {
        $moderator = Moderator::find($moderatorId);

        // Check if the moderator exists
        if (!$moderator) {
            abort(404, 'Moderator not found');
        }

        // Retrieve notes uploaded by users with the same faculty and subject as the moderator
        $notes = Note::where('faculty_id', $moderator->faculty_id)
            ->where('subject_id', $moderator->subject_id)
            ->paginate(7);

        return view('note.for_moderator', compact('notes', 'moderator'));
    }

    public function viewApprovedNotes($moderatorId)
    {
        $moderator = Moderator::with('user:id,name')->find($moderatorId);

        // Check if the moderator exists
        if (!$moderator) {
            abort(404, 'Moderator not found');
        }

        // Retrieve notes uploaded by users with the same faculty and subject as the moderator
        // and where the status is approved by the current moderator
        $notes = Note::where('faculty_id', $moderator->faculty_id)
            ->where('subject_id', $moderator->subject_id)
            ->where('status', 'approved')
            ->paginate(5);

        // Access the name through the user relationship
        $moderatorName = $moderator->user->name;

        return view('note.approvedNotes', compact('notes', 'moderator', 'moderatorName'));
    }


    public function viewRejectedNotes($moderatorId)
    {
        $moderator = Moderator::with('user:id,name')->find($moderatorId);

        // Check if the moderator exists
        if (!$moderator) {
            abort(404, 'Moderator not found');
        }

        // Retrieve notes uploaded by users with the same faculty and subject as the moderator
        // and where the status is approved by the current moderator
        $notes = Note::where('faculty_id', $moderator->faculty_id)
            ->where('subject_id', $moderator->subject_id)
            ->where('status', 'rejected')
            ->paginate(5);

        // Access the name through the user relationship
        $moderatorName = $moderator->user->name;

        return view('note.rejectedNotes', compact('notes', 'moderator', 'moderatorName'));
    }




    public function viewUnderReviewNotes($moderatorId)
    {
        $moderator = Moderator::with('user:id,name')->find($moderatorId);

        // Check if the moderator exists
        if (!$moderator) {
            abort(404, 'Moderator not found');
        }

        // Retrieve notes uploaded by users with the same faculty and subject as the moderator
        // and where the status is approved by the current moderator
        $notes = Note::where('faculty_id', $moderator->faculty_id)
            ->where('subject_id', $moderator->subject_id)
            ->where('status', 'under-review')
            ->paginate(5);

        // Access the name through the user relationship
        $moderatorName = $moderator->user->name;

        return view('note.underSupervision', compact('notes', 'moderator', 'moderatorName'));
    }


    public function viewPendingNotes($moderatorId)
    {
        $moderator = Moderator::with('user:id,name')->find($moderatorId);

        // Check if the moderator exists
        if (!$moderator) {
            abort(404, 'Moderator not found');
        }

        // Retrieve notes uploaded by users with the same faculty and subject as the moderator
        // and where the status is approved by the current moderator
        $notes = Note::where('faculty_id', $moderator->faculty_id)
            ->where('subject_id', $moderator->subject_id)
            ->where('status', 'pending')
            ->paginate(5);

        // Access the name through the user relationship
        $moderatorName = $moderator->user->name;

        return view('note.pendingNotes', compact('notes', 'moderator', 'moderatorName'));
    }

    public function moderatorDashboard()
    {
        $user = Auth::user();

        // Check if the user is a moderator
        if ($user->moderator) {
            $moderator = $user->moderator;
            $userCount = User::count();
            $moderatorCount = Moderator::count();
            $subject = $moderator->subject;
            $faculty = $moderator->faculty;
            $subjectCount = Subject::count();
            $facultyCount = Faculty::count();
            $topSubjectCounts = Note::select('subject_id', DB::raw('count(*) as count'))
                ->groupBy('subject_id')
                ->orderByDesc('count')
                ->limit(5) // Get the top 5 subjects
                ->get();

            $topFacultyCounts = Note::select('faculty_id', DB::raw('count(*) as count'))
                ->groupBy('faculty_id')
                ->orderByDesc('count')
                ->limit(5) // Get the top 5 faculties
                ->get();


            $users = DB::table('users')
                ->join('moderators', 'users.id', '=', 'moderators.user_id')
                ->join('subjects', 'moderators.subject_id', '=', 'subjects.id')
                ->join('faculties', 'moderators.faculty_id', '=', 'faculties.id')
                ->where('subjects.id', $moderator->subject_id)
                ->where('faculties.id', $moderator->faculty_id)
                ->get();


            return view('moderator.dashboard', compact('moderator', 'userCount', 'moderatorCount', 'subjectCount', 'facultyCount', 'users', 'subject', 'faculty', 'topSubjectCounts', 'topFacultyCounts'));
        } else {
            // Handle the case where the user is not a moderator
            abort(403, 'Unauthorized');
        }
    }

    public function dashboardData()
    {
        $topSubjectCounts = Note::select('subject_id', DB::raw('count(*) as count'))
            ->groupBy('subject_id')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $topFacultyCounts = Note::select('faculty_id', DB::raw('count(*) as count'))
            ->groupBy('faculty_id')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return response()->json([
            'topSubjectCounts' => $topSubjectCounts,
            'topFacultyCounts' => $topFacultyCounts,
        ]);
    }
    public function reviewNote(Note $note)
    {
        $status = $note->status; // Assuming your Note model has a 'status' attribute

        return view('note.review', compact('note', 'status'));
    }
    public function updateNote(Request $request, Note $note)
    {
        // Validate the request
        $request->validate([
            'review' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected,under-review',
        ]);

        // Attach the moderator with review to the note
        $moderator = auth()->user()->moderator;
        $moderatorReview = [
            'review' => $request->input('review'),
        ];

        $note->moderators()->attach([$moderator->id => $moderatorReview], ['review' => $request->input('review')]);

        // Update the status of the note
        $note->status = $request->input('status');
        $note->save();
        // $note->load('user');
        // $note->notifyUserAboutReview();
        $noteUser = $note->user;
        $nameOf = $noteUser->name;
        $notifyStatus = $request->input('status');
        event(new UserStatus($notifyStatus, $nameOf));
        Alert::success('succesfully Reviewed the note');


        return redirect()->route('moderator.dashboard')->with('success', 'Note review and status updated successfully');
    }
}
