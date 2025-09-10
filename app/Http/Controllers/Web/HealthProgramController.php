<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HealthProgram;

class HealthProgramController extends Controller
{
    /**
     * Provide all health programs (active + inactive).
     */
    public function provideData()
    {
        $programs = HealthProgram::all();

        return response()->json([
            'success' => true,
            'data' => $programs
        ]);
    }
}
