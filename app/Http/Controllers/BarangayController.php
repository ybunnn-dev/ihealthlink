<?php


namespace App\Http\Controllers;

use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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

        foreach ($barangays as $barangay) {
            $barangay->puroks_count = rand(3, 7);    
            $barangay->residents_count = rand(1200, 4500); 
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

   // in app/Http/Controllers/BarangayController.php

    // No changes needed here! This method already works with the new route.
    public function show(Barangay $barangay)
    {
        return view('mho.spec-barangay', compact('barangay'));
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