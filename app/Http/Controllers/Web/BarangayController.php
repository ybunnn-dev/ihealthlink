<?php


namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Web\PurokController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\Models\Barangay;
use App\Models\Midwife;

class BarangayController extends Controller
{
    /**
     * Display a paginated and searchable list of barangays for the web view.
     */
    public function listView(Request $request)
    {
        // Start query with purok count
        $query = Barangay::withCount('puroks')->where('status', 'active');;

        // --- Search Logic ---
        $query->when($request->filled('search'), function ($q) use ($request) {
            $searchTerm = $request->input('search');
            return $q->where('name', 'like', "%{$searchTerm}%");
        });

        // --- Sorting Logic ---
        $filter = $request->input('filter', 'alpha_asc');
        if ($filter === 'alpha_asc') {
            $query->orderBy('name', 'asc');
        } elseif ($filter === 'alpha_desc') {
            $query->orderBy('name', 'desc');
        }

        // --- Date Sorting Logic ---
        $dateSort = $request->input('sort_date');
        if ($dateSort === 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($dateSort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        }

        // Paginate results
        $barangays = $query->paginate(15)->appends($request->query());

        // Add random residents count for now
        foreach ($barangays as $barangay) {
            $barangay->residents_count = rand(1200, 4500);
        }

        return view('mho.barangay-list', compact('barangays'));
    }

    // --- Other API/CRUD methods remain the same ---
    public function search(Request $request)
    {
        // Get and Validate Query Parameters
        $searchQuery = $request->input('search');
        $sortBy = $request->input('sort_by', 'name');
        $dateFilter = $request->input('date_filter');

        // Include puroks_count directly in the query
        $query = Barangay::withCount('puroks')
            ->where('status', 'active'); //  Only active barangays

        // Apply search and date filter logic
        $query->when($searchQuery, fn($q) => $q->where('name', 'like', "%{$searchQuery}%"));
        $query->when($dateFilter, function ($q, $dateFilter) {
            switch ($dateFilter) {
                case 'week': return $q->where('created_at', '>=', now()->subWeek());
                case 'month': return $q->where('created_at', '>=', now()->subMonth());
                case 'year': return $q->where('created_at', '>=', now()->subYear());
            }
        });

        // Database-level sorting
        if (in_array($sortBy, ['name', 'created_at', 'puroks_count'])) {
            $query->orderBy($sortBy, 'asc');
        }

        $barangays = $query->paginate(15)->withQueryString();

        // Add Temporary Residents Count
        $barangays->getCollection()->transform(function ($barangay) {
            $barangay->residents_count = rand(1200, 4500);
            return $barangay;
        });

        // Collection-level sorting for temporary fields
        if ($sortBy === 'residents_count') {
            $sortedItems = $barangays->getCollection()->sortBy('residents_count')->values();
            $barangays->setCollection($sortedItems);
        }

        return response()->json($barangays);
    }


    public function index()
    {
        return Barangay::withCount(['puroks', 'residents'])->get();
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('barangays', 'name'),
            ],
        ]);

        // Create the new barangay, adding the logged-in user's ID
        $barangay = Barangay::create([
            'name' => $validated['name'],
            'user_id' => Auth::id(), // <-- This gets the logged-in user's ID
        ]);

        return response()->json([
            'message' => 'Barangay added successfully!',
            'barangay' => $barangay
        ], 201);
    }

    public function filter(){

    }

    // No changes needed here! This method already works with the new route.
    public function show(Barangay $barangay)
    {
        // Load barangay with its puroks
        $barangay->load('puroks');

        // Query for the current midwife assigned to this barangay
        $midwife = Midwife::with('users')
            ->where('brgy_id', $barangay->id)
            ->where('status', 'active') // optional filter
            ->first();

        // Add counts (still sample/random for now)
        $barangay->residents_count  = rand(1200, 4500);
        $barangay->households_count = rand(300, 800);
        $barangay->families_count   = rand(350, 950);

        // Assign midwife (will be null if none is found)
        $barangay->assigned_midwife = $midwife ? $midwife->name : null;

        \Log::info('Assigned midwife: ' . ($barangay->assigned_midwife ?? 'None'));

        // Call PurokController to get purok data
        $purokController = new PurokController();
        $puroks = $purokController->getByBarangay($barangay);

        return view('mho.spec-barangay', compact('barangay', 'puroks'));
    }


    public function update(Request $request, Barangay $barangay)
    {
        $validated = $request->validate([
            'name' => [
                'required', 
                'string', 
                'max:255',
                Rule::unique('barangays', 'name')->ignore($barangay->id),
            ],
        ]);

        // Update barangay
        $barangay->update([
            'name' => $validated['name'],
        ]);

        return response()->json([
            'message' => 'Barangay updated successfully!',
            'barangay' => $barangay
        ]);
    }

    public function deactivate(Request $request, Barangay $barangay)
    {
        $barangay->update([
            'status' => 'inactive'
        ]);

        return response()->json([
            'message' => 'Barangay set to inactive successfully.'
        ]);
    }

    
}