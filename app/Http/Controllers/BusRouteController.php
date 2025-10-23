<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusRoute;

class BusRouteController extends Controller
{
    public function index()
    {
        $routes = BusRoute::all();
        return view('admin.busroute.index', compact('routes'));
    }

    public function create()
    {
        return view('admin.busroute.create');
    }

    public function store(Request $request)
    {
        BusRoute::create([
            'origin' => $request->origin,
            'destination' => $request->destination,
            'distance_km' => $request->distance_km,
        ]);
        return redirect()->route('busroute.index')->with('success', 'Rute berhasil ditambahkan!');
    }

    public function edit(BusRoute $busroute)
    {
        return view('admin.busroute.edit', compact('busroute'));
    }

    public function update(Request $request, BusRoute $busroute)
    {
        $busroute->update($request->only(['origin', 'destination', 'distance_km']));
        return redirect()->route('busroute.index')->with('success', 'Rute berhasil diperbarui!');
    }

    public function destroy(BusRoute $busroute)
    {
        $busroute->delete();
        return redirect()->route('busroute.index')->with('success', 'Rute berhasil dihapus!');
    }
}
