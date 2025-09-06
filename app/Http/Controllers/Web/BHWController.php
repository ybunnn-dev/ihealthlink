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


class BHWController extends Controller
{
    public function index(){
        return view('midwife.BHWs');
    }
}
