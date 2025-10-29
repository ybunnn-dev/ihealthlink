<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\UserManual;
use App\Models\Module;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 5;

        // Get filter parameters
        $search = $request->input('search', '');
        $moduleId = $request->input('module', '');

        // Build query - only fetch active FAQs
        $query = UserManual::with(['module', 'addedBy'])
            ->where('action_type', 'active')
            ->orderBy('created_at', 'desc');

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $lowerSearch = strtolower($search);
                $q->whereRaw('LOWER(question) LIKE ?', ["%{$lowerSearch}%"])
                ->orWhereRaw('LOWER(content) LIKE ?', ["%{$lowerSearch}%"])
                ->orWhereRaw('LOWER(category) LIKE ?', ["%{$lowerSearch}%"]);
            });
        }

        // Apply module filter
        if ($moduleId) {
            $query->where('module_id', $moduleId);
        }

        $faqs = $query->paginate($perPage)->appends($request->except('page'));

        // Get all modules for the filter dropdown
        $modules = Module::orderBy('module_name', 'asc')->get();

        // If AJAX request, return JSON with partial views
        if ($request->ajax()) {
            return response()->json([
                'html' => view('components.faq.faq-list', compact('faqs'))->render(),
                'pagination' => $faqs->links()->render()
            ]);
        }

        return view('mho.faq', compact('faqs', 'modules'));
    }
   public function fetchFaq(UserManual $manual)
    {
        return response()->json([
            'success' => true,
            'faq' => $manual
        ]);
    }

    // Update FAQ
    public function update(Request $request, UserManual $manual)
    {
        $validated = $request->validate([
            'module_id' => 'required',
            'category' => 'required|string|max:255',
            'question' => 'required|string',
            'content' => 'required|string'
        ]);

        $manual->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'FAQ updated successfully',
            'faq' => $manual
        ]);
    }

    // Soft delete FAQ (set to inactive)
    public function deactivate(UserManual $manual)
    {
        $manual->update(['action_type' => 'inactive']);

        return response()->json([
            'success' => true,
            'message' => 'FAQ deactivated successfully'
        ]);
    }

    // Optional: Reactivate FAQ
    public function activate(UserManual $manual)
    {
        $manual->update(['action_type' => 'active']);

        return response()->json([
            'success' => true,
            'message' => 'FAQ activated successfully'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'module_id' => 'required',
            'category' => 'required|string|max:255',
            'question' => 'required|string',
            'content' => 'required|string'
        ]);

        // Set action_type to active by default
        $validated['action_type'] = 'active';
        
        // Add the authenticated user's ID
        $validated['added_by'] = auth()->id();
        $validated['action_type'] = 'active';

        $faq = UserManual::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'FAQ created successfully',
            'faq' => $faq
        ], 201);
    }


}
