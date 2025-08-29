<?php

namespace App\Http\Controllers;

use App\Models\Purok;
use Illuminate\Http\Request;

class PurokController extends Controller
{
    public function index()
    {
        return Purok::with('barangay')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brgy_id' => 'required|exists:barangays,id'
        ]);

        return Purok::create($request->only('name', 'brgy_id'));
    }

    public function show(Purok $purok)
    {
        return $purok->load('barangay');
    }

    public function update(Request $request, Purok $purok)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brgy_id' => 'required|exists:barangays,id'
        ]);

        $purok->update($request->only('name', 'brgy_id'));
        return $purok;
    }

    public function destroy(Purok $purok)
    {
        $purok->delete();
        return response()->noContent();
    }
}
