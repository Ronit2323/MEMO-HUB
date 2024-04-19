<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function show()
    {
        return view('user.password');
    }
    public function updatePassword(Request $request, $userId)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Ensure the user exists
        $user = User::find($userId);
        if (!$user) {
            Alert::error('Password Cannot be changed');
            return redirect()->route('user.show')->with('error', 'User does not exist.');
        }

        // Check if the current password matches the password stored in the database
        if (!Hash::check($request->current_password, $user->password)) {
            Alert::error('Your current password does not match');
            return redirect()->route('user.show')->with('error', 'Password does not match.');
        }
        if (strlen($request->new_password) < 8) {
            Alert::error('Password should be at least 8 characters long');
            return redirect()->route('user.show')->with('error', 'Password should be at least 8 characters long.');
        }

        // Update the user's password with the new hashed password
        $user->password = Hash::make($request->new_password);
        $user->save();
        Alert::success('Password Changed Successfully');

        return redirect()->route('home')->with('success', 'Password changed successfully.');
    }
    public function edit($userId)
    {
        $user = User::find($userId);
        return view('user.edit', compact('user'));
    }
    public function update(Request $request, $userId)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
        ]);

        // Find the user by ID
        $user = User::findOrFail($userId);

        // Update the user's name and email
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        // Redirect back with success message
        Alert::success('Successfully Updated user detail');

        return redirect()->route('home')->with('success', 'Successfully Updated user detail');
    }
}
