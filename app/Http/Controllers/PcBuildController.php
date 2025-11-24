<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;

class PcBuildController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $partsQuery = Part::query();

        if ($search) {
            $partsQuery->where('name', 'like', "%{$search}%")
                       ->orWhere('category', 'like', "%{$search}%");
        }

        $parts = $partsQuery->paginate(10);

        $buildParts = [];
        $totalPrice = 0;

        return view('pcbuild', compact('parts', 'buildParts', 'totalPrice'));
    }

    public function add(Request $request)
    {
        return back(); // temporary, just to prevent errors
    }

    public function remove(Request $request)
    {
        return back(); // temporary
    }
}
