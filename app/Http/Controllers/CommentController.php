<?php

namespace App\Http\Controllers;

use App\Notifications\statusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\note;
use App\Models\comment;
use Illuminate\Support\Facades\Notification;

use App\Models\Notification as AppNotification;


class CommentController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::check()) {

            // Validate request data
            $request->validate([
                'note_id' => 'required|exists:notes,id',
                'comment_body' => 'required|string',
            ]);

            // Create the comment
            $comment = new Comment();
            $comment->user_id = Auth::user()->id; // Assuming user is authenticated
            $comment->note_id = $request->note_id;
            $comment->comment_body = $request->comment_body;
            $comment->save();
           


            return redirect()->back()->with('success', 'Comment posted successfully.');
        } else {
            return redirect()->back()->with('error', 'Please login first.');
        }
    }
    public function edit(Comment $comment)
    {
        // You may want to add some authorization logic here to check if the user is allowed to edit the comment

        return view('comments.edit', compact('comment'));
    }

    // Update a comment
    public function update(Request $request, Comment $comment)
    {
        // Validate the request data
        $request->validate([
            'comment_body' => 'required|string',
        ]);

        // Update the comment
        $comment->update([
            'comment_body' => $request->comment_body,
        ]);

        return redirect()->back()->with('success', 'Comment updated successfully.');
    }

    // Delete a comment
    public function destroy(Comment $comment)
    {
        // You may want to add some authorization logic here to check if the user is allowed to delete the comment

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
