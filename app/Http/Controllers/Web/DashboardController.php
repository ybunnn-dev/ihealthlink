<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DailyActivities;
use App\Models\Schedules;
use App\Models\Midwife;
use App\Models\Resident;
use App\Models\Medicine;

class DashboardController extends Controller
{
    // Method to show the dashboard
    public function index($barangay)
    {   
        $user = auth()->user();

        // Determine personnel: BHW with role 4 or Midwife
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        $schedules = Schedules::where('brgy_id', $personnel->brgy_id)
                                            ->where('status', 'active')
                                            ->whereDate('date', '>=', \Carbon\Carbon::today())
                                            ->with('barangay')
                                            ->get();

        $residents = Resident::whereHas('family.household.purok', function($q) use ($personnel) {
                                $q->where('brgy_id', $personnel->brgy_id);
                            });

        $totalResidents = $residents->count();
        
        $residentCollection = $residents->get(); // actually fetch the residents

        $under5 = $residentCollection->filter(function($resident) {
            return \Carbon\Carbon::parse($resident->birthdate)->age < 5;
        })->count();

        $sixtyUp = $residentCollection->filter(function($resident) {
            return \Carbon\Carbon::parse($resident->birthdate)->age >= 60;
        })->count();

        $pregnantCount = Resident::whereHas('family.household.purok', function($q) use ($personnel) {
            $q->where('brgy_id', $personnel->brgy_id);
            })
            ->whereHas('basicHealthRecord', function($q) {
                $q->where('is_pregnant', 1);
            })
            ->count();
        $medicines = Medicine::withSum('activeInventories as total_stock', 'stock')
            ->where('brgy_id', $personnel->brgy_id)
            ->orderByDesc('total_stock')
            ->get();

        return view('midwife.dashboard', [
            'barangay' => $barangay,
            'scheduledActivities' => $schedules,
            'totalResidents' => $totalResidents,
            'under5' => $under5,
            'sixtyUp' => $sixtyUp,
            'pregnant' => $pregnantCount,
            'medicines' => $medicines,
        ]);
    }

}
