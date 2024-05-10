<?php

namespace App\Http\Controllers;

use App\Events\ModNotify;
use App\Models\category;
use App\Models\note;
use App\Models\Subject;
use App\Models\faculty;
use App\Models\Moderator;
use App\Models\User;
use App\Models\FacultySubject;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Laravel\Prompts\Note as PromptsNote;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade as PDF;






class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check if the request has a 'search' parameter
        if ($request->has('search')) {
            // Retrieve the search query from the request
            $searchQuery = $request->input('search');

            // Perform a search query to find notes that match the search query
            $notes = Note::where('user_id', auth()->id())
                ->where('title', 'like', $searchQuery . '%')
                ->paginate(7);
        } else {
            // If no search parameter is provided, retrieve all notes of the authenticated user
            $notes = Note::where('user_id', auth()->id())->paginate(7);
        }

        // Pass the notes to the view
        return view('note.index', compact('notes'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        $faculties = Faculty::all();
        $categories = category::all();
        $user = auth()->user();
        return view('note.create', compact('subjects', 'faculties', 'user', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'user_id' => 'required',
            'faculty_id' => 'required',
            'subject_id' => 'required',
            'category_id' => 'required',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'summary' => 'required',
            'tags' => 'required',
        ]);

        $note = new Note();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            if (!$file->isValid()) {
                // File upload failed, notify the user
                Alert::error('Invalid File', 'Please upload a valid file in PDF!')->persistent(true);
                return redirect()->back()->withInput();
            }

            // Move the uploaded file to the 'public/note' directory
            $file->storeAs('note', $filename, 'public');

            $note->file = $filename;
        }

        $note->title = $request->title;
        $note->user_id = $request->user_id;
        $note->subject_id = $request->subject_id;
        $note->faculty_id = $request->faculty_id;
        $note->category_id = $request->category_id;
        $note->summary = $request->summary;
        $note->tags = $request->tags;

        // Save the note first to get the note ID
        $note->save();

        $moderators = Moderator::where('subject_id', $request->subject_id)
            ->where('faculty_id', $request->faculty_id)
            ->get();

        // Attach moderators with reviews
        foreach ($moderators as $moderator) {
            $review = 'Put your default review here'; // You can set a default review if needed
            $note->moderators()->attach($moderator->id, ['review' => $review]);
        }

        $note->status = 'pending';
        $note->save();
        event(new ModNotify($request->user()->name, $request->subject_id, $request->faculty_id));

        Alert::success('Sucessfully uploaded', 'Note is being sent to moderator for checking.');




        return redirect()->route('notes.index');
    }

    // protected function generatePdfPreview(Note $note)
    // {
    //     $pdfPath = storage_path('app/public/note/') . $note->file;
    //     $previewPath = storage_path('app/public/note/previews/') . pathinfo($note->file, PATHINFO_FILENAME) . '_preview.jpg';

    //     // Create the preview image
    //     $pdf = new Pdf($pdfPath);
    //     $pdf->setOutputFormat('jpeg');
    //     $pdf->saveImage($previewPath);
    // }

    /**
     * Display the specified resource.
     */
    public function show(note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(note $note)
    {
        $user = auth()->user();
        $faculties = Faculty::all();
        $categories = Category::all();

        // Retrieve subjects associated with the selected faculty
        $selectedFaculty = $note->faculty_id;
        $facultySubjects = FacultySubject::where('faculty_id', $selectedFaculty)->get();

        // Extract subject IDs from faculty_subject records
        $subjectIds = $facultySubjects->pluck('subject_id')->toArray();

        // Retrieve subjects based on the extracted subject IDs
        $subjects = Subject::whereIn('id', $subjectIds)->get();

        return view('note.edit', compact('note', 'user', 'faculties', 'categories', 'subjects'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, note $note)
{
    // Check if the note status is pending
    if ($note->status === 'pending') {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string',
            'summary' => 'required|string',
            'tags' => 'nullable|string',
            'faculty_id' => 'required|exists:faculties,id',
            'subject_id' => 'required|exists:subjects,id',
            'category_id' => 'required|exists:categories,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // Adjust file size as needed
        ]);

        // Update the note with the new data
        $note->update([
            'title' => $request->title,
            'summary' => $request->summary,
            'tags' => $request->tags,
            'faculty_id' => $request->faculty_id,
            'subject_id' => $request->subject_id,
            'category_id' => $request->category_id,
        ]);

        // Handle file update if a new file is provided
        if ($request->hasFile('file')) {
            // Validate the file
            $validated = $request->validate([
                'file' => 'required|mimes:pdf,doc,docx|max:2048',
            ]);

            if ($validated) {
                // Store the new file in the storage directory
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('note', $fileName, 'public');

                // Update the file name in the note record
                $note->file = $fileName;
            } else {
                // File upload failed due to validation, notify the user
                return back()->with('error', 'Invalid file. Please upload a valid file (PDF, DOC, DOCX) with a maximum size of 2048 KB.');
            }
        }

        // Save the changes to the note
        $note->save();

        // Redirect the user to the desired page with a success message
        return redirect()->route('notes.index')->with('success', 'Note updated successfully!');
    } else {
        // Redirect the user back with a message indicating that update is not allowed
        return back()->with('error', 'Note update is not allowed because the note has already been approved by a moderator.');
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(note $note)
    {
        if ($note->file) {
            $imagePath = storage_path('app/public/note/' . $note->file);

            if (file_exists($imagePath)) {
                try {
                    unlink($imagePath);
                    // File deleted successfully
                } catch (\Exception $e) {
                    // Log the error or handle it appropriately
                    Log::error('Error deleting image: ' . $e->getMessage());
                }
            } else {
                Log::warning('Image file does not exist: ' . $imagePath);
            }
        }

        // Now delete the note
        $note->delete();

        return redirect()->route('notes.index');
    }
    public function like(Request $request, Note $note)
    {
        $user = auth()->user();

        // Check if the user has already liked the note
        $like = $note->likesDislikes()->where('user_id', $user->id)->first();

        if ($like) {
            // If already liked, delete the like record to undo the like
            $like->delete();
            $liked = false;
        } else {
            // If not liked, create a new like record
            $note->likesDislikes()->create(['user_id' => $user->id, 'liked' => true]);
            $liked = true;
        }

        $note->refreshLikesDislikesCount(); // Refresh likes and dislikes counts

        return response()
            ->json([
                'liked' => $liked,
                'likesCount' => $note->likesCount(),
                // If you have dislikes, include this line
            ]);
    }


    public function searchApprovedNotes(Request $request)
    {
        $subjects = Subject::all();
        $faculties = Faculty::all();
        $categories = Category::all();
        $user = auth()->user();
        $search = $request->input('search');

        // If a search term is provided, filter notes based on tags and first letter
        if ($search) {
            $approvedNotes = Note::where('status', 'approved')
                ->where(function ($query) use ($search) {
                    $query->where('tags', 'like', $search . '%')
                        ->orWhere('title', 'like', $search . '%');
                })
                ->paginate(6);
        } else {
            // Retrieve all approved notes if no search term is provided
            $approvedNotes = Note::where('status', 'approved')->paginate(6);
        }

        // Return the view with the filtered or all approved notes
        return view('searchNote', compact('approvedNotes', 'search', 'subjects', 'faculties', 'user', 'categories'));
    }



    public function getFilteredNotes(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Extract filter parameters from the request
        $facultyId = $request->input('faculty_id');
        $subjectId = $request->input('subject_id');
        $categoryId = $request->input('category_id');

        // Query notes based on filter parameters
        $query = Note::where('faculty_id', $facultyId)
            ->where('status', 'approved');

        if ($subjectId) {
            $query->where('subject_id', $subjectId);
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Fetch filtered notes
        $notes = $query->get();

        // Return notes as a JSON response
        return response()->json(['notes' => $notes]);
    }
    public function toggleFavorite(Note $note)
    {
        $user = auth()->user();

        // Check if the user has already favorited the note
        $isFavorited = $user->favoriteNotes()->where('note_id', $note->id)->exists();

        if ($isFavorited) {
            // If already favorited, remove the favorite
            $user->favoriteNotes()->where('note_id', $note->id)->delete();
            $message = 'Note removed from favorites.';
        } else {
            // If not favorited, add the favorite
            $user->favoriteNotes()->create(['note_id' => $note->id]);
            $message = 'Note added to favorites.';
        }

        // Retrieve the user's favorite notes
        $favoriteNotes = $user->favoriteNotes()->with('note')->get();

        // Return the home view with the data
        return view('home', compact('favoriteNotes', 'message'));
    }
    public function showFavorites()
    {
        $user = auth()->user();

        // Retrieve the user's favorite notes
        $favoriteNotes = $user->favoriteNotes()->with('note')->paginate(7);

        return view('user.favorites', compact('favoriteNotes'));
    }
    public function showUserNotes($userId)
    {
        // Number of items per page

        $user = User::with(['notes.moderators'])->find($userId);

        // Paginate the notes manually
        $notes = $user->notes()->paginate(7);

        return view('user.notes', compact('user', 'notes'));
    }
    public function viewNote($noteId)
    {
        $note = Note::findOrFail($noteId);
        $comments = $note->comments()->with('user')->get();
        $editingCommentId = null; // Eager load user relationship
        $filePath = asset('storage/note/' . $note->file);
        $paymentDone = Payment::where('user_id', auth()->id())
            ->where('status', 'success')
            ->exists();


        return view('note.viewNote', compact('note', 'comments', 'editingCommentId', 'filePath', 'paymentDone'));
    }


    public function deleteFavorite($Favoriteid)
    {
        // Find the favorite record by its ID
        $favorite = Favorite::findOrFail($Favoriteid);

        // Delete the favorite record
        $favorite->delete();

        // Redirect back or to any other route after deletion
        return redirect()->back()->with('success', 'Favorite deleted successfully');
    }
}
