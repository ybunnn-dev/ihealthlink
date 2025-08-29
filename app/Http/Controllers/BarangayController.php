<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use Illuminate\Http\Request;

class BarangayController extends Controller
{
    public function index()
    {
        return Barangay::with('puroks')->get();
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        return Barangay::create($request->only('name'));
    }

    public function show(Barangay $barangay)
    {
        return $barangay->load('puroks');
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
