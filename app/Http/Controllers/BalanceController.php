<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\BalanceSuccessfulMail;

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
            'transaction_id' => 'required|string|unique:transactions,transaction_id',
            'file_upload' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // max 2MB
        ]);

        $user = auth()->user();
        $account = $user->account;


        DB::transaction(function () use ($request, $account) {

            // Optional file upload
            $filePath = null;
            if ($request->hasFile('file_upload')) {
                $filePath = $request->file('file_upload')->store('transactions', 'public');
            }

            // Update balance
            $newBalance = $account->balance + $request->amount;
            // $account->update([
            //     'balance' => $newBalance,
            // ]);

            // accounts table account_number need to be changed to id


            // Create transaction
            Transaction::create([

                'account_id' => $account->id,
                'transaction_id' => $request->transaction_id,
                'type'           => 'deposit',
                'amount'         => $request->amount,
                'balance_after'  => $newBalance,
                'note'           => 'Balance added by user',
                'file_upload'    => $filePath,
                'status'         => 'pending',
            ]);

             Mail::to('easyxpres9@gmail.com')->send(
            new BalanceSuccessfulMail($request->transaction_id, $request->amount)
        );
        });

        return redirect()
            ->route('dashboard')
            ->with('success', 'Balance added successfully!');
    }

    // Pending Balance Data
      public function pendingBalance()
{
    // User name relation with transactions
    // Fetch pending transactions
    // $pendingTransactions = Transaction::where('status', 'pending')->get();

    $pendingTransactions = Transaction::with('account.user')->orderBy('created_at', 'desc')
        ->get();

    return view('backend.balance.pending', compact('pendingTransactions'));
}

// approved balance data
public function approvedBalance($id)
{
   $transaction = Transaction::with('account')->findOrFail($id);

    // Update recharge status
    $transaction->status = 'approved';
    $transaction->save();

    if ($transaction->account) {
        $transaction->account->balance += $transaction->amount;
        $transaction->account->save();
    }

    return redirect()->back()->with('success', 'Balance approved successfully.');
}


// rejected balance data
public function rejectedBalance($id)
{
    $transaction = Transaction::with('account')->findOrFail($id);
        $transaction->status = 'rejected';
        $transaction->save();

        if ($transaction->account) {
        $transaction->account->balance -= $transaction->amount;
        $transaction->account->save();
    }
    return redirect()->back()->with('success', 'Balance rejected successfully.');
}

public function downloadFile(Transaction $transaction)
{
    if (!$transaction->file_upload || !Storage::disk('public')->exists($transaction->file_upload)) {
        abort(404, 'File not found');
    }

    return Storage::disk('public')->download($transaction->file_upload);
}

public function changeStatus(Request $request, Transaction $transaction)
{
    $request->validate([
        'status' => 'required|in:pending,approved,rejected'
    ]);

    $transaction->status = $request->status;
    $transaction->save();

    return back()->with('success', 'Transaction status updated successfully!');
}

 public function balanceHistory()
    {
      
        return view('frontend.balance.history');
    }

}