<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
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
    
            // Perform a search query to find categories whose names start with the specified first letter
            $categories = Category::where('category_name', 'like', $firstLetter . '%')->paginate(7);
        } else {
            // If no search parameter is provided, retrieve all categories
            $categories = Category::paginate(7);
        }
    
        // Pass the categories to the view
        return view('category.index', compact('categories'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'category_name'
            ]

        );
        $category = new category();
        $category->category_name = $request->category_name;
        $category->save();
        Alert::success('The category of the note is added successfully');
        return redirect()->route('categorys.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, category $category)
    {
        $request->validate([
            'category_name'

        ]);
        $category->category_name = $request->category_name;
        $category->update();
        return redirect()->route('categorys.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(category $category)
    {
        $category->delete();
        return redirect()->route('categorys.index');
    }
}
