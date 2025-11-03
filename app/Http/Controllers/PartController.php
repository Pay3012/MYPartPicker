<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;

class PartController extends Controller
{
    public function index(Request $request)
    {
        // Get the search keyword from the query string (?search=...)
        $search = $request->input('search');

        // Build the query
        $query = Part::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        // Get all results (paginate for large lists)
        $parts = $query->orderBy('id', 'asc')->paginate(10);

        // Return the Blade view
        return view('parts', compact('parts', 'search'));
    }
}
