<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Midwife;

class MidwifeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all personnels that are midwives (role_id = 2)
        $midwives = Midwife::with(['users', 'barangays']) // eager load the relations you used
            ->where('role_id', 2)
            ->get();

        // Re-organize into table-friendly rows
        $rows = $midwives->map(function ($m) {
            // tolerant access: use plural relation name if present, otherwise singular
            $user = $m->users ?? $m->user ?? null;
            $barangay = $m->barangays ?? $m->barangay ?? null;

            // build full name from parts (fall back to name if older schema)
            $parts = array_filter([
                $user->firstName ?? null,
                $user->middleName ?? null,
                $user->lastName ?? null,
                $user->suffix ?? null,
            ]);
            $fullName = $parts ? implode(' ', $parts) : ($user->name ?? 'N/A');

            return [
                'midwife_no'   => $m->id,
                'name'         => $fullName,
                'barangay'     => $barangay->name ?? 'N/A',
                'date_added'   => optional($m->created_at)->format('M d, Y'),
                'date_updated' => optional($m->updated_at)->format('M d, Y'),
            ];
        });

        // Log the reorganized rows (array form)
        Log::info('Midwives reorganized:', $rows->toArray());

        // Pass the rows to the Blade view as $midwives
        return view('mho.midwives', ['midwives' => $rows]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
       
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
