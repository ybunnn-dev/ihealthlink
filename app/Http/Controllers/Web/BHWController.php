<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\BHWCredentialsMail;
use App\Mail\MidwifeCredentialsMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


use App\Models\BHW;
use App\Models\Barangay;
use App\Models\User;
use App\Models\Midwife;

class BHWController extends Controller
{
    /**
     * Display a listing of the BHWs for the authenticated midwife's barangay.
     */
    public function index(): View
    {
        // 1. Get the authenticated user (the midwife).
        $user = Auth::user();

        // 2. Find the midwife's personnel record to get their assigned barangay.
        // It's safer to query the Personnel model directly.
        // Assuming 'role_id' for a midwife is 2.
        $midwifePersonnel = Midwife::where('user_id', $user->id)
            ->where('role_id', 2)
            ->first();

        // 3. Handle cases where the midwife might not be properly assigned to a barangay.
        if (!$midwifePersonnel || !$midwifePersonnel->brgy_id) {
            // Return the view with an empty collection. The @forelse loop in the view will handle this gracefully.
            return view('midwife.BHWs', ['bhws' => collect()]);
        }

        // 4. Fetch the BHWs assigned to the midwife's barangay.
        $bhws = BHW::query()
            // Filter BHWs by the midwife's barangay ID.
            ->where('brgy_id', $midwifePersonnel->brgy_id)
            ->where('status', 'active')
            ->with('user')
            ->get() // Get all results first
            ->sortBy('name') // Now sort by the 'name' accessor from your model
            ->values(); // Reset the collection keys

        // Note: For pagination with this sorting method, you'd need to manually create a paginator.
        // For simplicity with up to a few hundred BHWs, ->get() is fine.
        // If you expect thousands, we should revert to a database-level sort with a JOIN.

        // 5. Return the view and pass the collection of BHWs to it.
        return view('midwife.BHWs', compact('bhws'));
    }

    public function show(BHW $bhw): View
    {
        // Eager load the relationships to prevent extra database queries in the view.
        // Even for a single model, this is a good habit.
        $bhw->load('users', 'barangays');

        // The BHWs-profile.blade.php file you sent has a typo in its name.
        // Make sure the filename is 'BHWs-profile.blade.php'
        return view('midwife.BHWs-profile', compact('bhw'));
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstName'   => 'required|string|max:50',
            'lastName'    => 'required|string|max:50',
            'middleName'  => 'nullable|string|max:50',
            'suffix'      => 'nullable|string|max:10',
            'birthdate'   => 'required|date_format:m/d/Y',
            'age'         => 'required|integer|min:0|max:150',
            'sex'         => 'required|in:Male,Female,Other',
            'email'       => 'required|email|max:100',
            'contactNo'   => 'required|string|min:7|max:20',
            'privilege'   => 'required|integer|in:3,4',
            'civilStatus' => 'required|in:Single,Married,Divorced,Widowed,Separated',
            'religion'    => 'required|string|max:100',
        ]);

        Log::info('Validated BHW Data:', $validated);

        // get current logged-in midwife
        $midwifePersonnel = Midwife::where('user_id', Auth::id())
            ->where('role_id', 2)
            ->first();

        if (!$midwifePersonnel) {
            return response()->json([
                'success' => false,
                'message' => 'Midwife personnel record not found'
            ], 404);
        }

        $password = Str::random(8);
        $birthdate = Carbon::createFromFormat('m/d/Y', $validated['birthdate'])->format('Y-m-d');

        // create user account for BHW
        $user = User::create([
            'firstName'   => $validated['firstName'],
            'lastName'    => $validated['lastName'],
            'middleName'  => $validated['middleName'],
            'suffix'      => $validated['suffix'],
            'birthdate'   => $birthdate,
            'contact_no'  => $validated['contactNo'],
            'email'       => $validated['email'],
            'password'    => bcrypt($password),
            'role_id'     => $validated['privilege'],
            'civil_status' => $validated['civilStatus'],
            'religion' => $validated['religion'],
            'sex' => $validated['sex'],
        ]);

        // create personnel record for BHW
        $personnel = BHW::create([
            'user_id' => $user->id,
            'role_id' => $validated['privilege'],
            'brgy_id' => $midwifePersonnel->brgy_id, // ✅ fixed
            'status'  => 'active',
        ]);

        // send email with credentials
        Mail::to($user->email)->send(new BHWCredentialsMail($user->email, $password));

        return response()->json([
            'success' => true,
            'message' => 'BHW created successfully and credentials emailed',
            'data' => [
                'user'      => $user,
                'personnel' => $personnel,
                // 'password' => $password // optional for testing only
            ]
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'firstName'    => 'required|string|max:50',
            'lastName'     => 'required|string|max:50',
            'middleName'   => 'nullable|string|max:50',
            'suffix'       => 'nullable|string|max:10',
            'birthdate'    => 'nullable|date',
            'sex'          => 'nullable|string|max:10',
            'civil_status' => 'nullable|string|max:20',
            'religion'     => 'nullable|string|max:50',
            'email'        => 'required|email|unique:users,email,' . $id,
            'contact_no'   => 'nullable|string|max:20',
            'role_id'      => 'required|integer',
        ]);
        
        // Log the validated data
        Log::info('Validated BHW update data:', $validated);

        $user = User::findOrFail($id);

        // Step 3: Update user with validated data
        $user->update($validated);

        //  Step 4: Return JSON response
        $bhw = BHW::where('user_id', $user->id)->first();

        if ($bhw) {
            $bhw->update([
                'role_id' => $validated['role_id'],
            ]);
        }
            // Don’t update yet, just return it
        return response()->json([
            'message' => 'Payload received successfully',
            //'validated' => $validated
        ]);
    }

    public function remove(Request $request, $id)
    {
        //  Log incoming data
        \Log::info("Removing BHW with id you vakla: " . $id);

        // 🔹 Find the user
        $user = User::findOrFail($id);

        \Log::info('vakla');
        
        // Set user inactive
        $user->update([
            'status' => 'inactive'
        ]);

        // 🔹 Find related personnel (BHW) record
        $bhw = BHW::where('user_id', $user->id)->first();

        if ($bhw) {
            $bhw->update([
                'status' => 'inactive'
            ]);
        }

        return response()->json([
            'message' => 'BHW removed successfully (set to inactive)',
            'user'    => $user,
            'bhw'     => $bhw
        ]);
    }

}
