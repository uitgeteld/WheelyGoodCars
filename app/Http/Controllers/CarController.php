<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Services\RdwService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::latest()->get();
        return view('cars.index', compact('cars'));
    }

    /**
     * Display the authenticated user's cars.
     */
    public function myListings()
    {
        $cars = Car::where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('cars.my', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cars.create');
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

        $validated['user_id'] = Auth::id();
        $validated['license_plate'] = strtoupper($validated['license_plate']);

        Car::create($validated);

        return redirect()->route('cars.index')
            ->with('success', 'Auto succesvol toegevoegd aan je aanbod!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        $car->increment('views');
        return view('cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $car->delete();

        return redirect()->route('cars.myListings')
            ->with('success', 'Auto succesvol verwijderd uit je aanbod!');
    }
}
