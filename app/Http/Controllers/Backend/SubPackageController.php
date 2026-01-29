<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageDetail;
use Illuminate\Http\Request;

class SubPackageController extends Controller
{
    public function index()
    {
        // Logic to list all sub-packages
        $subpackages = PackageDetail::all();
        return view('backend.subpackages.index', compact('subpackages'));
    }

    public function create()
    {
        // Logic to show form to create a new sub-package
        $packages = Package::all();
        return view('backend.subpackages.create', compact('packages'));
    }

    public function store(Request $request)
    {
        // Logic to store a new sub-package
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'commission' => 'required|numeric',
            'offer_price' => 'nullable|numeric',
        ]);
        PackageDetail::create($request->all());
        return redirect()->route('admin.subpackages.list')->with('success', 'Sub-package created successfully.');
    }

    public function edit($id)
    {
        // Logic to show form to edit an existing sub-package
        $subpackage = PackageDetail::findOrFail($id);
        $packages = Package::all();
        return view('backend.subpackages.edit', compact('subpackage', 'packages'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing sub-package
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'commission' => 'required|numeric',
            'offer_price' => 'nullable|numeric',
        ]);
        $subpackage = PackageDetail::findOrFail($id);
        $subpackage->update($request->all());
        return redirect()->route('admin.subpackages.list')->with('success', 'Sub-package updated successfully.');
    }

    public function destroy($id)
    {
        // Logic to delete an existing sub-package
        $subpackage = PackageDetail::findOrFail($id);
        $subpackage->delete();
        return redirect()->route('admin.subpackages.list')->with('success', 'Sub-package deleted successfully.');
    }

    // status change method
    public function changeStatusSub($id)
    {
        $subpackage = PackageDetail::findOrFail($id);

        // Toggle status correctly for ENUM
        $subpackage->status = ($subpackage->status === 'active')
            ? 'inactive'
            : 'active';

        $subpackage->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
