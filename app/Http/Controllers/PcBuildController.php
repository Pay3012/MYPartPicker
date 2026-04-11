<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\Pcbuild;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PcBuildController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $search = $request->input('search');

        $partsQuery = Part::query();

        if ($search) {
            $partsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('specs->chipset', 'like', "%{$search}%");
            });
        }

        $parts = $partsQuery->paginate(10)->withQueryString();

        $sessionBuild = session('build', []);
        $buildParts = [];
        $totalPrice = 0;

        if (!empty($sessionBuild)) {
            $dbParts = Part::whereIn('id', array_keys($sessionBuild))->get()->keyBy('id');

            foreach ($sessionBuild as $partId => $quantity) {
                if ($dbParts->has($partId)) {
                    $part = clone $dbParts[$partId];
                    $part->amount = $quantity;
                    $buildParts[] = $part;
                    $totalPrice += $part->price * $quantity;
                }
            }
        }

        return view('pcbuild', compact('parts', 'buildParts', 'totalPrice', 'search'));
    }

    public function add(Request $request)
    {
        $partId = (int) $request->input('part_id');
        $build = session('build', []);
        $build[$partId] = ($build[$partId] ?? 0) + 1;
        session(['build' => $build]);

        return back();
    }

    public function save(Request $request)
    {
        $request->validate([
            'build_name' => 'required|string|max:100',
        ]);

        $sessionBuild = session('build', []);

        if (empty($sessionBuild)) {
            return back()->with('error', 'Your build is empty.');
        }

        $dbParts = Part::whereIn('id', array_keys($sessionBuild))->get()->keyBy('id');

        $build = Pcbuild::create([
            'user_id' => auth()->id(),
            'name'    => $request->input('build_name'),
        ]);

        $syncData = [];
        foreach ($sessionBuild as $partId => $quantity) {
            if ($dbParts->has($partId)) {
                $syncData[$partId] = [
                    'quantity'     => $quantity,
                    'custom_price' => $dbParts[$partId]->price,
                ];
            }
        }

        $build->parts()->attach($syncData);

        session()->forget('build');

        return back()->with('success', 'Build saved successfully!');
    }

    public function decrement(Request $request)
    {
        $partId = (int) $request->input('part_id');
        $build = session('build', []);

        if (isset($build[$partId])) {
            $build[$partId]--;
            if ($build[$partId] <= 0) {
                unset($build[$partId]);
            }
        }

        session(['build' => $build]);

        return back();
    }

    public function remove(Request $request)
    {
        $partId = (int) $request->input('part_id');
        $build = session('build', []);
        unset($build[$partId]);
        session(['build' => $build]);

        return back();
    }

    public function destroy(Pcbuild $build)
    {
        abort_if($build->user_id !== auth()->id(), 403);
        $build->parts()->detach();
        $build->delete();

        return redirect()->route('dashboard')->with('success', 'Build deleted.');
    }

    public function rename(Request $request, Pcbuild $build)
    {
        abort_if($build->user_id !== auth()->id(), 403);
        $request->validate(['name' => 'required|string|max:100']);
        $build->update(['name' => $request->input('name')]);

        return redirect()->route('dashboard')->with('success', 'Build renamed.');
    }
}
