<?php

namespace App\Http\Controllers;

use App\Models\Recharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RechargeController extends Controller
{
    public function submitRecharge(Request $request)
    {
        // Validate the request data
        $request->validate([
            'mobile' => 'required|string|max:15',
            'amount' => 'required|numeric|min:1',
        ]);

       $authID = auth()->id();
       $accountID = DB::table('accounts')->where('user_id', $authID)->value('id');
        
        Recharge::create([
            'account_id' => $accountID,
            'mobile' => $request->input('mobile'),
            'amount' => $request->input('amount'),
            'status' => 'pending', // or any other status logic
        ]);

        // Redirect back with a success message
        return redirect()->route('dashboard')->with('success', 'Recharge request submitted successfully!');
    }

    public function rechargeHistory()
    {
        $authID = auth()->id();
        $accountID = DB::table('accounts')->where('user_id', $authID)->value('id');

        $recharges = Recharge::where('account_id', $accountID)->orderBy('created_at', 'desc')->get();

        return view('frontend.recharge.history', compact('recharges'));
    }

    public function packageHistory()
    {
       

        return view('frontend.package.history');
    }

    // Admin Functions
    public function index()
    {
        $recharges = Recharge::with('account.user')->orderBy('created_at', 'desc')->get();
    return view('admin.recharges.index', compact('recharges'));
    }

    public function approveRecharge($id)
{
    // Find the recharge
    $recharge = Recharge::with('account')->findOrFail($id);

    // Update recharge status
    $recharge->status = 'approved';
    $recharge->save();

    // Update account balance
    if ($recharge->account) {
        $recharge->account->balance -= $recharge->amount;
        $recharge->account->save();
    }

    return redirect()->route('admin.recharges.pending')
                     ->with('success', 'Recharge approved successfully.');
}


    public function rejectRecharge($id)
    {
        $recharge = Recharge::with('account')->findOrFail($id);
        $recharge->status = 'rejected';
        $recharge->save();

        if ($recharge->account) {
        $recharge->account->balance += $recharge->amount;
        $recharge->account->save();
    }

        return redirect()->route('admin.recharges.pending')->with('success', 'Recharge rejected successfully.');
    }
}
