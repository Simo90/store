<?php

namespace App\Http\Controllers\Auth;
use Auth;
use Hash;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{

    public function showForm(){
        return view('auth.passwords.change');
    }

    public function changePassword(Request $request){
        
        if ( !(Hash::check($request->get('current-password'), Auth::user()->password)) ) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
        if( strcmp($request->get('current-password'), $request->get('new-password')) == 0 ){
            
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
        
        $validatedData = $request->validate([
            
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
        
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        
        return redirect()->back()->with("success","Password changed successfully !");
    }
}