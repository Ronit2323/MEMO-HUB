<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FacultySubject;

class association extends Controller
{
    public function index()
    {
        $association = FacultySubject::paginate(7);
        return view('admin.associationtable', compact('association'));
    }
}
