<?php

namespace App\Http\Controllers;

use App\Models\chat;
use Illuminate\Http\Request;
use App\Models\faculty;
use App\Models\Subject;

use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        $faculties = Faculty::all();
        $selectedFacultyId = null; // Set initial value to null
        $selectedSubjectId = null; // Set initial value to null
        return view('user.chat', compact('subjects', 'faculties', 'selectedFacultyId', 'selectedSubjectId'));
    }
    public function store(Request $request)
    {
        if (Auth::check()) {
            // Validate request data
            $request->validate([
                'subject_id' => 'required',
                'faculty_id' => 'required',
                'chat_body' => 'required|string',
            ]);

            // Create the comment
            $chat = new Chat();
            $chat->user_id = Auth::user()->id; // Assuming user is authenticated
            $chat->subject_id = $request->subject_id;
            $chat->faculty_id = $request->faculty_id;
            $chat->chat_body = $request->chat_body;
            $chat->save();

            // Return JSON response with the newly created message
            return response()->json([
                'success' => true,
                'message' => $chat // Assuming $chat contains the newly created message
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Please login first.'
            ]);
        }
    }




    public function fetchMessages(Request $request)
    {
        $facultyId = $request->faculty_id;
        $subjectId = $request->subject_id;

        // Query the database to fetch chat messages based on faculty and subject IDs
        $messages = Chat::where('faculty_id', $facultyId)
            ->where('subject_id', $subjectId)
            ->with('user') // Assuming user relation exists
            ->get();

        foreach ($messages as $message) {
            // Check if the logged-in user is the owner of the message
            $message->isOwner = ($message->user->id === Auth::id());
        }


        // If you only want to include certain fields from the user model (like user_name),
        // you can specify them in the select method.
        // For example:
        // ->with(['user' => function ($query) {
        //     $query->select('id', 'user_name'); // Adjust fields as per your user model
        // }])

        return response()->json($messages);
    }

    public function deleteMessage($id)
    {
        // Find the message by its ID
        $message = Chat::find($id);

        // Check if the message exists
        if (!$message) {
            return response()->json(['success' => false, 'error' => 'Message not found'], 404);
        }

        // Check if the authenticated user is the owner of the message
        if ($message->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        // Delete the message
        $message->delete();

        // Return a success response
        return response()->json(['success' => true]);
    }
}
