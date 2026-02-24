<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\iBankingSuccessfulMail;
use App\Models\IbankingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class IbankingOrderController extends Controller
{
     public function addiBanking(Request $request)
{
    $request->validate([
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

        IbankingOrder::create([
            'account_id' => $account->id,
            'bank_name_id'     => $request->bank_name_id,
            'account_no'     => $request->account_no,
            'amount'     => $request->amount,
            'bdt_amount'     => $request->bdt_amount,
            'status'     => 'pending',
        ]);

        // ✅ DEDUCT balance
        DB::table('accounts')
            ->where('id', $account->id)
            ->decrement('balance', $request->amount);

               Mail::to('easyxpres9@gmail.com')->send(
            new iBankingSuccessfulMail($request->account_no, $request->amount)
        );
    });

    return redirect()
        ->route('dashboard')
        ->with('success', 'iBanking successful. Balance deducted.');
}

 public function appAddiBanking(Request $request)
{
    $request->validate([
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

        IbankingOrder::create([
            'account_id' => $account->id,
            'bank_name_id'     => $request->bank_name_id,
            'account_no'     => $request->account_no,
            'amount'     => $request->amount,
            'bdt_amount'     => $request->bdt_amount,
            'status'     => 'pending',
        ]);

        // ✅ DEDUCT balance
        DB::table('accounts')
            ->where('id', $account->id)
            ->decrement('balance', $request->amount);

               Mail::to('easyxpres9@gmail.com')->send(
            new iBankingSuccessfulMail($request->account_no, $request->amount)
        );
    });

    return redirect()
        ->route('app_dashboard')
        ->with('success', 'iBanking successful. Balance deducted.');
}

 public function iBankingHistory()
    {
        $authID = auth()->id();
        $accountID = DB::table('accounts')->where('user_id', $authID)->value('id');
        // packageorderl data fetch
        $packages = IbankingOrder::where('account_id', $accountID)->orderBy('created_at', 'desc')->get();
        return view('frontend.ibanking.history', compact('packages'));
    }

     public function appiBankingHistory()
    {
        $authID = auth()->id();
        $accountID = DB::table('accounts')->where('user_id', $authID)->value('id');
        // packageorderl data fetch
        $packages = IbankingOrder::where('account_id', $accountID)->orderBy('created_at', 'desc')->get();
        return view('frontend.ibanking.app_history', compact('packages'));
    }

     public function iBankingOrder()
    {
        $packageOrders = IbankingOrder::with('bank')->orderBy('created_at', 'desc')->get();

        return view('backend.ibanking_orders.index', compact('packageOrders'));
    }

     public function approveOrder($id)
    {
        $order = IbankingOrder::with('account')->findOrFail($id);
        $order->status = 'approved';
        $order->save();

       

        return redirect()->back()->with('success', 'iBanking Order approved successfully.');
    }
    // reject order method
    public function rejectOrder($id)
    {
        $order = IbankingOrder::with('account')->findOrFail($id);
        $order->status = 'rejected';
        $order->save();

         if ($order->account) {
        $order->account->balance += $order->amount;
        $order->account->save();
    }

        return redirect()->back()->with('success', 'iBanking Order rejected successfully.');
    }

public function uploadSlip(Request $request, $id)
{
    $request->validate([
        'upload_slip' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $order = IBankingOrder::findOrFail($id);

    if ($request->hasFile('upload_slip')) {

        $filePath = $request->file('upload_slip')
                            ->store('transactions', 'public');

        $order->upload_slip = $filePath;
    }


    $order->save();

    return back()->with('success', 'Slip uploaded successfully.');
}

}
