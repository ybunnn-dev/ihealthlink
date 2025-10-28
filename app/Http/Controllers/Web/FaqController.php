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

        // Build query
        $query = UserManual::with(['module', 'addedBy'])
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
}
