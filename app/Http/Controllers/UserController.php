<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function allUsers()
    {
        $profiles = Profile::getAllUser();
        return view('backend.users-admin.index', compact('profiles'));
    }

    public function editUser($user_id)
    {
        $user = User::getSingleUser($user_id);
        $profile = Profile::getSingleProfile($user_id);
        $roles = ['user' => 'User', 'seller' => 'Seller', 'admin' => 'Admin'];

        return view('backend.users-admin.edit', compact('user', 'profile', 'roles'));
    }

    public function updateUser(Request $request, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:2',
            'role' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $request->all();

        $user = User::getSingleUser($user_id);
        $profile = Profile::getSingleProfile($user_id);

        if ($user && $profile) {
            $user->update([
                'name' => $input['name'],
                'role' => $input['role'],
                'status' => $input['status'],
            ]);

            $profile->update([
                'name' => $input['name'],
                'phone' => $input['phone'],
                'address' => $input['address'],
            ]);
            Session::flash('success', 'User updated successfully');
        } else {
            Session::flash('error', 'Error while saving');
        }

        return redirect()->route('all-users');
    }
}
