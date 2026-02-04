<?php

namespace App\Http\Controllers;

use App\Models\MaleRecharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaleRechargeController extends Controller
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
        
        MaleRecharge::create([
            'account_id' => $accountID,
            'mobile' => $request->input('mobile'),
            'amount' => $request->input('amount'),
            'status' => 'pending', // or any other status logic
        ]);

        // Redirect back with a success message
        return redirect()->route('dashboard')->with('success', 'Male Recharge request submitted successfully!');
    }

    public function rechargeHistory()
    {
        $authID = auth()->id();
        $accountID = DB::table('accounts')->where('user_id', $authID)->value('id');

        $recharges = MaleRecharge::where('account_id', $accountID)->orderBy('created_at', 'desc')->get();

        return view('frontend.male_recharge.history', compact('recharges'));
    }

    public function index()
    {
        $recharges = MaleRecharge::with('account.user')->orderBy('created_at', 'desc')->get();
    return view('admin.male_recharges.index', compact('recharges'));
    }

     public function approveRecharge($id)
{
    // Find the recharge
    $recharge = MaleRecharge::with('account')->findOrFail($id);

    // Update recharge status
    $recharge->status = 'approved';
    $recharge->save();

    // Update account balance
    if ($recharge->account) {
        $recharge->account->balance -= $recharge->amount;
        $recharge->account->save();
    }

    return redirect()->route('admin.male.recharges.pending')
                     ->with('success', 'Male Recharge approved successfully.');
}

public function rejectRecharge($id)
    {
        $recharge = MaleRecharge::with('account')->findOrFail($id);
        $recharge->status = 'rejected';
        $recharge->save();

        if ($recharge->account) {
        $recharge->account->balance += $recharge->amount;
        $recharge->account->save();
    }

        return redirect()->route('admin.male.recharges.pending')->with('success', 'Male Recharge rejected successfully.');
    }
}
