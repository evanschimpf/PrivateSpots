<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpotController extends Controller
{
    public function get() {
        DB::table('spots')->get();

        return view('ajax-request');
    }

    public function put(Request $request) {
        $data = $request->all();
        #create or update your data here

        return response()->json(['success'=>'Ajax request submitted successfully']);
    }
}
