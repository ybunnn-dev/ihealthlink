<?php

namespace App\Http\Controllers;

use App\Models\Purok;
use App\Models\Barangay;
use Illuminate\Http\Request;

class PurokController extends Controller
{
    public function index()
    {
        return Purok::with('barangay')->get();
    }

    public function getByBarangay(Barangay $barangay)
    {
        $puroks = Purok::where('brgy_id', $barangay->id)->get();

        $puroks->transform(function ($purok) {
            $purok->households_count = rand(10, 50);
            $purok->residents_count  = rand(50, 300);
            return $purok;
        });

        return $puroks;
    }
    
}
