<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
     public function index()
    {
        $users = User::where('is_admin', false)->get();
        return view('admin.users', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'approved';
        $user->save();

        return back()->with('success', 'User Approved');
    }

    public function userList()
    {
        // $users = User::where('is_admin', false)->get();
        $users = User::with('account')->where('is_admin', false)->get();
        return view('backend.user.list', compact('users'));
    }

    
}
