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
    public function index(){
         $programs = HealthProgram::paginate(10);

        return view('mho.health-program-list', [
            'healthPrograms' => $programs
        ]);
    }

    public function show(HealthProgram $healthProgram)
    {
        // If you want to eager-load relationships later:
        // $healthProgram->load('programFields', 'enrolledResidents');

        return view('mho.spec-health-program', [
            'healthProgram' => $healthProgram
        ]);
    }

}
