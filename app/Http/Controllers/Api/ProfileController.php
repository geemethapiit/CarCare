<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
   public function index()
   {
    $userDetails = User::where('id', Auth::id())->get();
    return response()->json($userDetails);
   }





   public function update(Request $request)
{
    $request->validate([
        'profile_pic' => 'nullable|image|max:2048', // Allow image up to 2MB
        'name' => 'required|string',
        'email' => 'required|string|email',
        'phoneNo' => 'required|string',
        'address' => 'required|string',
    ]);

    $user = Auth::user();

    // Check if an image is uploaded
    if ($request->hasFile('profile_pic')) {
        $image = $request->file('profile_pic');
        $imagePath = $image->store('profile_pics', 'public');
        $user->profile_pic = $imagePath; // Save the image path in the database
    }

    // Update other profile details
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->phoneNo = $request->input('phoneNo');
    $user->address = $request->input('address');
    $user->save();

    return response()->json(['message' => 'Profile updated successfully!']);
}


}