<?php

namespace App\Http\Controllers;

use App\Models\MobileBanking;
use App\Models\MobileBankingOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobileBankingController extends Controller
{
     public function index()
    {
        $mobileBanking = MobileBanking::all();
        return view('backend.mobile_banking.index', compact('mobileBanking'));
    }

      public function create()
    {
        // Logic to show form to create a new package
        return view('backend.mobile_banking.create');
    }
 public function store(Request $request)
    {

     
        $request->validate([
            'name' => 'required|string|max:255',
            'image_icon' => 'nullable|image|mimes:webp,svg,png,jpg,jpeg|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image_icon')) {
            $imagePath = $request->file('image_icon')->store('packages', 'public');
        }

        MobileBanking::create([
            'name' => $request->name,
            'image_icon' => $imagePath,
        ]);

        return redirect()
            ->route('admin.mobile.banking.list')
            ->with('success', 'Mobile Banking created successfully');
    }

     public function edit($id)
    {
        // Logic to show form to edit an existing package
        $package = MobileBanking::findOrFail($id);
        return view('backend.mobile_banking.edit', compact('package'));
    }

     public function update(Request $request, $id)
    {
        // Logic to update an existing package
        $package = MobileBanking::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'image_icon' => 'nullable|image|mimes:webp,svg,png,jpg,jpeg|max:2048',
        ]);
        if ($request->hasFile('image_icon')) {
            $imagePath = $request->file('image_icon')->store('packages', 'public');
            $package->image_icon = $imagePath;
        }
        $package->name = $request->name;
        $package->save();
        return redirect()
            ->route('admin.mobile.banking.list')
            ->with('success', 'Mobile Banking updated successfully');
    }

     public function destroy($id)
    {
        // Logic to delete a package
        $package = MobileBanking::findOrFail($id);
        $package->delete();
        return redirect()
            ->route('admin.mobile.banking.list')
            ->with('success', 'Mobile Banking deleted successfully');
    }

       public function changeStatus($id)
{
    $package = MobileBanking::findOrFail($id);

    // Toggle status correctly for ENUM
    $package->status = ($package->status === 'active')
        ? 'inactive'
        : 'active';

    $package->save();

    return redirect()->back()->with('success', 'Status updated successfully.');
}

  public function mobileBankingHistory()
    {
       $authID = auth()->id();
        $accountID = DB::table('accounts')->where('user_id', $authID)->value('id');
        // packageorderl data fetch
        $packages = MobileBankingOrder::where('account_id', $accountID)->orderBy('created_at', 'desc')->get();
        return view('frontend.mobile_banking.history', compact('packages'));
    }
    
}
