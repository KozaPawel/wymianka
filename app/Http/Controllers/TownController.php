<?php

namespace App\Http\Controllers;

use App\Models\Town;
use Illuminate\Http\Request;

class TownController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'county' => 'nullable',
            'province' => 'required|string',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        $search = $request->name . ($request->filled('county') ? ' ' . $request->county . ' ' : ' ') . $request->province;

        Town::create([
            'name' => $validatedData['name'],
            'county' => $validatedData['county'],
            'province' => $validatedData['province'],
            'lat' => $validatedData['lat'],
            'lon' => $validatedData['lon'],
            'search' => $search
        ]);

        return redirect()->back()
            ->with('success', 'Dodano nową miejscowość');
    }

    public function update(Request $request, Town $town)
    {
        $town->update(
            $request->validate([
                'name' => 'required|string',
                'county' => 'nullable',
                'province' => 'required|string',
                'lat' => 'required|numeric',
                'lon' => 'required|numeric',
                ]),
        );

        $search = $request->name . ($request->filled('county') ? ' ' . $request->county . ' ' : ' ') . $request->province;

        $town->update(['search' => $search]);

        return redirect()->back()
            ->with('success', 'Zaktualizowano miejscowość');
        
    }

    public function destroy(Town $town)
    {
        $town->deleteOrFail();

        return redirect()->back()
            ->with('success', 'Usunięto miejscowość');
    }

}
