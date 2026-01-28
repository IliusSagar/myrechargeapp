<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalanceController extends Controller
{
    // Show the form to add balance
    public function showAddForm()
    {
        return view('balance.add');
    }

    // Handle the balance addition
    public function addBalance(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // Assuming you have an authenticated user
        $user = auth()->user();
        $user->balance += $request->input('amount');
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Balance added successfully!');
    }
}
