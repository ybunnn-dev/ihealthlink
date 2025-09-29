<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserManual;

class UserManualController extends Controller
{
    public function index()
    {
        // Get all manuals, maybe with related modules if you set relationships
        $manuals = UserManual::with('module')->get();

        return view('midwife.faqs', [
            'manuals' => $manuals
            
        ]);
    }

      public function getResident(Request $request)
    {
        return response()->json(['message' => 'Controller works!']);
    }
}
