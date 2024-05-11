<?php

namespace App\Http\Controllers;

use App\Models\note;
use App\Models\faculty;
use App\Models\Subject;
use App\Models\Payment;
use App\Models\notificationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get the currently logged-in user
        $user = Auth::user();

        // Get the latest ten notes of the logged-in user
        $notes = Note::where('user_id', $user->id)
            ->latest() // Order by the latest records first
            ->take(10) // Limit the result to the latest ten records
            ->get();
        $notesBySubject = Note::where('user_id', $user->id)
            ->groupBy('subject_id')
            ->selectRaw('subject_id, COUNT(*) as count')
            ->pluck('count', 'subject_id');
            $hasPayments = Payment::where('user_id', $user->id)->exists();

            // Fetch payment data if available
            $paymentData = $hasPayments ? Payment::where('user_id', $user->id)->latest()->first() : null;
        
    
        // Get the subject names
        $subjects = Subject::whereIn('id', $notesBySubject->keys())->pluck('subject_name', 'id');
        $totalNotes = Note::where('user_id', $user->id)->count();
        $approvedNotesCount = Note::where('user_id', $user->id)->where('status', 'approved')->count();
        $pendingNotesCount = Note::where('user_id', $user->id)->where('status', 'pending')->count();
        $rejectedNotesCount = Note::where('user_id', $user->id)->where('status', 'rejected')->count();
        $underReviewNotesCount = Note::where('user_id', $user->id)->where('status', 'under-review')->count();
        return view('layout.userDash', compact('notes', 'totalNotes','approvedNotesCount','pendingNotesCount','rejectedNotesCount','underReviewNotesCount','subjects','notesBySubject','paymentData'));
    }
}
