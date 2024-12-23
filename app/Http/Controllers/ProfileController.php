<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Profile::getUserName(Auth::id());
        // dd($user);
        return view('frontend.profiles.profile', compact('user'));
    }

    public function changePassword()
    {
        $user = User::getSingleUser(Auth::id());
        return view('frontend.profiles.change-password', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $profile = Profile::getUserName(Auth::id());
        $user = User::getSingleUser(Auth::id());

        $input = $request->all();
        // dd($input);

        if (!$profile) {
            Session::flash('error', 'User profile not found');
        }

        $status_user = $user->update([
            'name' => $input['name']
        ]);
        $status_profile = $profile->update([
            'name' => $input['name'],
            'phone' => $input['phone'],
            'address' => $input['address'],
        ]);

        if ($status_user && $status_profile) {
            Session::flash('success', 'Profile updated successfully');
        } else {
            Session::flash('error', 'Error while saving please try again later');
        }

        return back();
    }

    public function changePasswordUser(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::getSingleUser(Auth::id());

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->route('profile')->with('success', 'Password changed successfully.');
        } else {
            return back()->withErrors(['old_password' => 'Incorrect old password.']);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
