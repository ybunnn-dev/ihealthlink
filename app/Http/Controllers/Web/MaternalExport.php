<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MaternalExport extends Controller
{
    /**
     * Receives maternal health data and exports it as a PDF.
     */
    public function exportIndividual(Request $request)
    {
        // Get all the data sent from the frontend
        $data = $request->all();

        // Load the Blade view for the PDF, passing the data to it
        $pdf = Pdf::loadView('reports.maternal-records', ['data' => $data]);

        // Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');
        
        // Stream the PDF to the browser.
        // The frontend fetch request will handle this as a download.
        return $pdf->stream('maternal-records.pdf');
    }
}