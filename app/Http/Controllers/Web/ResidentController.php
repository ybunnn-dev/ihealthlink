<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;
use App\Http\Requests\StoreResidentRequest;

class ResidentController extends Controller
{
    public function addResident(StoreResidentRequest $request)
    {
        // At this point, validation already happened
        // If invalid, Laravel automatically returns 422 with errors

        \Log::info('Validated Resident Payload:', $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Payload validated and logged'
        ]);
    }
}
