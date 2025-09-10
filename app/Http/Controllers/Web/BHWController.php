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
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


use App\Models\BHW;
use App\Models\Barangay;
use App\Models\User;
use App\Models\Personnel;

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
        $midwifePersonnel = Personnel::where('user_id', $user->id)
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

            // Eager load the 'users' relationship to prevent N+1 query problems.
            // This is critical for performance.
            ->with('users')

            // We can sort the collection after fetching since we need to sort by a computed attribute.
            // For larger datasets, a JOIN is better, but this is cleaner with accessors.
            ->get() // Get all results first
            ->sortBy('name') // Now sort by the 'name' accessor from your model
            ->values(); // Reset the collection keys

        // Note: For pagination with this sorting method, you'd need to manually create a paginator.
        // For simplicity with up to a few hundred BHWs, ->get() is fine.
        // If you expect thousands, we should revert to a database-level sort with a JOIN.

        // 5. Return the view and pass the collection of BHWs to it.
        return view('midwife.BHWs', compact('bhws'));
    }

    /**
     * Display the specified BHW's profile.
     *
     * @param BHW $bhw The BHW instance automatically resolved by Route-Model Binding.
     * @return View
     */
    public function show(BHW $bhw): View
    {
        // Eager load the relationships to prevent extra database queries in the view.
        // Even for a single model, this is a good habit.
        $bhw->load('users', 'barangays');

        // The BHWs-profile.blade.php file you sent has a typo in its name.
        // Make sure the filename is 'BHWs-profile.blade.php'
        return view('midwife.BHWs-profile', compact('bhw'));
    }
}
