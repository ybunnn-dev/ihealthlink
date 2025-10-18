<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Resident;
use App\Models\Family;
use App\Models\Household;
use App\Models\Barangay;
use App\Models\ResidenceHistory;
use App\Models\HealthProgram;
use App\Helpers\ProjectCrypt;
use App\Models\ActivityLog;
use App\Models\EnrolledResident;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PhilpenController extends Controller
{
    public function createNewScheds(){
        
    }
}
