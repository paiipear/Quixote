<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::all();
        return view('admin.bus.index', compact('buses'));
    }

    public function create()
    {
        return view('admin.bus.create');
    }

    public function store(Request $request)
    {
         Bus::create(
            [
                'model' => $request->model,
                'license_plate' => $request->license_plate,
                'capacity' => $request->capacity,
                'facilities' => $request->facilities,
                'description' => $request->description,
               
            ]
        );
        return redirect()->route('bus.index')->with('success', 'Bus berhasil ditambahkan!');
    }

    public function edit(Bus $bus)
    {
        return view('admin.bus.edit', compact('bus'));
    }


    public function update(Request $request, string $id)
    {
       $bus = Bus::find($id);
        if(!$bus){
            return redirect()->route('bus.index')->with('error', 'Bus tidak ditemukan!');
        } 
        $data = $request->only(['model', 'license_plate', 'capacity', 'facilities', 'description']);
        $bus->update($data);
        return redirect()->route('bus.index')->with('success', 'Bus berhasil diperbarui!');
    
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();
        return redirect()->route('bus.index')->with('success', 'Bus berhasil dihapus!');
    }
}
