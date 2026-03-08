<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Services\RdwService;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cars.create');
    }

    /**
     * AJAX endpoint to check license plate via RDW API.
     */
    public function checkKenteken(Request $request)
    {
        $request->validate([
            'license_plate' => 'required|string'
        ]);

        try {
            $vehicle = RdwService::getByPlate($request->license_plate);

            if (!$vehicle) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kenteken niet gevonden in RDW database'
                ], 404);
            }

            // Check if already listed by this user
            $exists = Car::where('user_id', auth()->id())
                ->where('license_plate', strtoupper($request->license_plate))
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Deze auto staat al in jouw aanbod'
                ], 422);
            }

            return response()->json([
                'success' => true,
                'data' => $vehicle
            ]);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kan geen verbinding maken met de RDW server. Probeer het later opnieuw.'
            ], 503);
        } catch (\Exception $e) {
            logger()->error('RDW API error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Er is een fout opgetreden. Probeer het later opnieuw.'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => 'required|string|unique:cars,license_plate',
            'make' => 'required|string',
            'model' => 'required|string',
            'price' => 'required|numeric|min:0',
            'mileage' => 'required|integer|min:0',
            'production_year' => 'nullable|integer',
            'seats' => 'nullable|integer',
            'doors' => 'nullable|integer',
            'weight' => 'nullable|integer',
            'color' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['license_plate'] = strtoupper($validated['license_plate']);

        Car::create($validated);

        return redirect()->route('cars.index')
            ->with('success', 'Auto succesvol toegevoegd aan je aanbod!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::findOrFail($id);
        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $car = Car::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $car = Car::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'mileage' => 'required|integer|min:0',
        ]);

        $car->update($validated);

        return redirect()->route('cars.index')
            ->with('success', 'Auto succesvol bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', 'Auto succesvol verwijderd uit je aanbod!');
    }
}
