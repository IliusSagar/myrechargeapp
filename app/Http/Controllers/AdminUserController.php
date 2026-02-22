<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

     public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejected';
        $user->save();

        return back()->with('success', 'User Rejected');
    }

    public function userList()
    {
        // $users = User::where('is_admin', false)->get();
        $users = User::with('account')->where('is_admin', false)->latest()->get();
        return view('backend.user.list', compact('users'));
    }

public function updateBalance(Request $request)
{
    // Validate request
    $request->validate([
        'account_number' => 'required|string',
        'amount' => 'required|numeric|min:1',
        'type' => 'required|in:add,deduct',
        'note' => 'required|string|max:500',
    ]);

    // Find account
    $account = Account::where('account_number', $request->account_number)->first();

    if (!$account) {
        return back()->with('error', 'Account not found.');
    }

    // Start DB transaction
    DB::beginTransaction();

    try {
        $amount = $request->amount;

        // Update balance based on type
        if ($request->type === 'add') {
            $account->balance += $amount;
            $transactionType = 'deposit'; // Transaction type
            $transactionAmount = $amount; // Positive amount
        } else {
            // Deduct balance
            if ($account->balance < $amount) {
                return back()->with('error', 'Insufficient balance.');
            }
            $account->balance -= $amount;
            $transactionType = 'withdraw';
            $transactionAmount = -$amount; // Negative amount
        }

        // Save account balance
        $account->save();

        // Create transaction record
        Transaction::create([
            'account_id'     => $account->id,
            'transaction_id' => 'ADMIN-' . strtoupper(uniqid()),
            'type'           => $transactionType,
            'amount'         => $transactionAmount,
            'balance_after'  => $account->balance,
            'note'           => $request->note,
            'status'         => 'approved',

          
        ]);

        DB::commit();

        return back()->with('success', 'Balance updated successfully.');
    } catch (\Exception $e) {
        DB::rollBack();

        // Optional: log error
        \Log::error('Balance Update Failed: ' . $e->getMessage());

        return back()->with('error', 'An error occurred while updating balance.');
    }
}

    
}
