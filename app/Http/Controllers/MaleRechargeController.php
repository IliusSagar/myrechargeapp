<?php

namespace App\Http\Controllers;

use App\Mail\MaleRechargeSuccessfulMail;
use App\Models\MaleRecharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RechargeSuccessfulMail;


class MaleRechargeController extends Controller
{
     public function submitRecharge(Request $request)
    {
        // Validate the request data
        $request->validate([
            'mobile' => 'required|string|max:15',
            'amount' => 'required|numeric|min:1',
        ]);

       $userId = auth()->id();
        $account = DB::table('accounts')
        ->where('user_id', $userId)
        ->lockForUpdate()
        ->first();

    if (! $account) {
        return back()->with('error', 'No account found.');
    }

    // ✅ Balance check
    if ($account->balance < $request->amount) {
        return back()->with('error', 'Insufficient balance.');
    }
        
         DB::transaction(function () use ($request, $account) {

        MaleRecharge::create([
            'account_id' => $account->id,
            'mobile'     => $request->mobile,
            'amount'     => $request->amount,
            'status'     => 'pending',
        ]);

        // ✅ DEDUCT balance
        DB::table('accounts')
            ->where('id', $account->id)
            ->decrement('balance', $request->amount);

            Mail::to('easyxpres9@gmail.com')->send(
            new MaleRechargeSuccessfulMail($request->mobile, $request->amount)
        );
            });
        // Redirect back with a success message
        return redirect()->route('dashboard')->with('success', 'Male Recharge request submitted successfully!');
    }

     public function appSubmitRecharge(Request $request)
    {
        // Validate the request data
        $request->validate([
            'mobile' => 'required|string|max:15',
            'amount' => 'required|numeric|min:1',
        ]);

       $userId = auth()->id();
        $account = DB::table('accounts')
        ->where('user_id', $userId)
        ->lockForUpdate()
        ->first();

    if (! $account) {
        return back()->with('error', 'No account found.');
    }

    // ✅ Balance check
    if ($account->balance < $request->amount) {
        return back()->with('error', 'Insufficient balance.');
    }
        
         DB::transaction(function () use ($request, $account) {

        MaleRecharge::create([
            'account_id' => $account->id,
            'mobile'     => $request->mobile,
            'amount'     => $request->amount,
            'status'     => 'pending',
        ]);

        // ✅ DEDUCT balance
        DB::table('accounts')
            ->where('id', $account->id)
            ->decrement('balance', $request->amount);

            Mail::to('easyxpres9@gmail.com')->send(
            new MaleRechargeSuccessfulMail($request->mobile, $request->amount)
        );
            });
        // Redirect back with a success message
        return redirect()->route('app_dashboard')->with('success', 'Male Recharge request submitted successfully!');
    }

    public function rechargeHistory()
    {
        $authID = auth()->id();
        $accountID = DB::table('accounts')->where('user_id', $authID)->value('id');

        $recharges = MaleRecharge::where('account_id', $accountID)->orderBy('created_at', 'desc')->get();

        return view('frontend.male_recharge.history', compact('recharges'));
    }

    public function appRechargeHistory()
    {
        $authID = auth()->id();
        $accountID = DB::table('accounts')->where('user_id', $authID)->value('id');

        $recharges = MaleRecharge::where('account_id', $accountID)->orderBy('created_at', 'desc')->get();

        return view('frontend.male_recharge.app_history', compact('recharges'));
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
