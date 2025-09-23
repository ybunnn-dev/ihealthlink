<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserManual;

class UserManualController extends Controller
{
    public function index()
    {
        // Get all manuals, maybe with related modules if you set relationships
        $manuals = UserManual::with('module')->get();

        return response()->json([
            'success' => true,
            'manuals' => $manuals
        ]);
    }
}
