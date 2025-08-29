<?php


namespace App\Http\Controllers;

use App\Models\Barangay;
use Illuminate\Http\Request;

class BarangayController extends Controller
{
    /**
     * Display a paginated and searchable list of barangays for the web view.
     */
    public function listView(Request $request)
    {
        // Start a query builder instance
        $query = Barangay::query();

        // We comment this out because we will add temporary data manually
        // $query->withCount(['puroks', 'residents']);

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

        // Paginate the results as usual
        $barangays = $query->paginate(15)->appends($request->query());

        // --- Add temporary data for display ---
        // This loop runs only if barangays were found and adds a random
        // number for purok and resident counts to each one.
        foreach ($barangays as $barangay) {
            $barangay->puroks_count = rand(3, 7);       // Assign a random number of puroks (e.g., between 3 and 7)
            $barangay->residents_count = rand(1200, 4500); // Assign a random number of residents
        }

        return view('mho.barangay-list', compact('barangays'));
    }
    // --- Other API/CRUD methods remain the same ---

    public function index()
    {
        return Barangay::withCount(['puroks', 'residents'])->get();
    }
    
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        return Barangay::create($request->only('name'));
    }

    public function show(Barangay $barangay)
    {
        return $barangay->loadCount(['puroks', 'residents']);
    }

    public function update(Request $request, Barangay $barangay)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $barangay->update($request->only('name'));
        return $barangay;
    }

    public function destroy(Barangay $barangay)
    {
        $barangay->delete();
        return response()->noContent();
    }
}