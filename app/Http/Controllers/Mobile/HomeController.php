<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Household;
use App\Models\Resident;
use App\Models\Schedules;
use App\Models\Medicine;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Determine personnel type (Midwife, BHW Web, or BHW)
        if ($user->bhwWeb && $user->bhwWeb->role_id == 4) {
            $personnel = $user->bhwWeb;
        } elseif ($user->bhw && $user->bhw->role_id == 3) {
            $personnel = $user->bhw;
        } else {
            $personnel = $user->midwife;
        }

        if (!$personnel) {
            abort(403, 'Unauthorized access.');
        }

        
        $pregnantCount = Resident::where('status', 'active')
            ->whereHas('family.household.purok', function ($q) use ($personnel) {
                $q->where('brgy_id', $personnel->brgy_id);
            })
            ->whereHas('basicHealthRecord', function ($q) {
                $q->where('is_pregnant', 1);
            })
            ->count();
            
        $upcomingSchedulesCount = Schedules::where('brgy_id', $personnel->brgy_id)
            ->whereDate('date', '>=', now()->toDateString())
            ->where('status', 'active')
            ->count();

        // Define what “low” means, e.g. total stock < 10
        $lowStockMedicinesCount = Medicine::where('brgy_id', $personnel->brgy_id)
            ->whereHas('inventories', function ($q) {
                $q->selectRaw('medicine_id, SUM(stock) as total_stock')
                ->groupBy('medicine_id')
                ->havingRaw('SUM(stock) < 20'); // threshold
            })
            ->count();

        return response()->json([
            'pregnantCount' => $pregnantCount,
            'upcomingSchedulesCount' => $upcomingSchedulesCount,
            'lowStockMedicinesCount' => $lowStockMedicinesCount,
        ]);
    }
}
