<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConsultationController extends Controller
{
    public function updateConsultation(Request $request)
    {
        // Log all incoming data
        Log::info('=== Consultation Update Request ===');
        Log::info('Consultation ID (from query): ' . $request->query('consultation_id'));
        Log::info('Request Body: ', $request->all());
        Log::info('Formatted Data: ' . json_encode($request->all(), JSON_PRETTY_PRINT));
        
        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Consultation update request received and logged',
            'consultation_id' => $request->query('consultation_id'),
            'data' => $request->all()
        ], 200);
    }
}
