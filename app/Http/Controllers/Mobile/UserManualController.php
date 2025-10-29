<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\UserManual;

class UserManualController extends Controller
{
    public function index()
    {
        // Get only active manuals, including their related modules
        $manuals = UserManual::with('module')
            ->where('action_type', 'active')
            ->get();

        return response()->json([
            'success' => true,
            'manuals' => $manuals
        ]);
    }
}
