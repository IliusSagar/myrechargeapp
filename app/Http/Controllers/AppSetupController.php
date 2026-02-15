<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppSetupController extends Controller
{
     public function content()
    {
        $appSetup = DB::table('app_setups')->where('id', 1)->first();

        return view('admin.app_setup.content', compact('appSetup'));
    }

     public function update(Request $request)
    {
       

        DB::table('app_setups')->updateOrInsert(
            ['id' => 1],
            [
                'add_balance_content'        => $request->add_balance_content
            ]
        );

        return redirect()
            ->route('admin.setup.content')
            ->with('success', 'App content updated successfully.');
    }

      public function social()
    {
        $appSetup = DB::table('app_setups')->where('id', 1)->first();

        return view('admin.app_setup.social', compact('appSetup'));
    }

     public function updateSocial(Request $request)
    {
       

        DB::table('app_setups')->updateOrInsert(
            ['id' => 1],
            [
                'facebook'        => $request->facebook,
                'youtube'        => $request->youtube,
                'telegram'        => $request->telegram
            ]
        );

        return redirect()
            ->route('admin.setup.social')
            ->with('success', 'App Social updated successfully.');
    }
}
