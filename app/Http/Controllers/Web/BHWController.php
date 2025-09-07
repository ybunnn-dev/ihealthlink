<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\MidwifeCredentialsMail;


use App\Models\BHW;
use App\Models\Barangay;
use App\Models\User;
use App\Models\Midwife;

class BHWController extends Controller
{
    public function index(){
        return view('midwife.BHWs');
    }

    public function getBHWs(){
        $midwife = Midwife::where('user_id', auth()->id())->first();

        if(!$midwife){
            return response()->json([
                'success' => false,
                'message' => 'No midwife found for this user.'
            ], 404);
        }

        $bhws = BHW::where('brgy_id', $midwife->brgy_id)->get();

        return response()->json([
            'success' => true,
            'data' => $bhws
        ]);
    }
}
