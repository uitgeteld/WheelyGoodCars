<x-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <a href="{{ route('cars.index') }}" class="text-sm text-gray-500 hover:underline mb-4 inline-block">&larr; Terug naar alle auto's</a>

        <div class="border rounded-xs shadow p-6">
            @if ($car->image)
            <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}" class="w-full max-h-96 object-cover rounded mb-6">
            @endif

            <h1 class="text-3xl font-bold mb-1">{{ $car->make }} {{ $car->model }}</h1>
            <p class="text-gray-500 mb-4">{{ $car->production_year }}</p>

            <p class="text-2xl font-bold text-green-700 mb-6">€{{ number_format($car->price, 2, ',', '.') }}</p>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="font-semibold">Kenteken:</span>
                    <span class="ml-2">{{ $car->license_plate }}</span>
                </div>
                <div>
                    <span class="font-semibold">Kilometerstand:</span>
                    <span class="ml-2">{{ $car->mileage }} km</span>
                </div>
                @if ($car->color)
                <div>
                    <span class="font-semibold">Kleur:</span>
                    <span class="ml-2">{{ $car->color }}</span>
                </div>
                @endif
                @if ($car->seats)
                <div>
                    <span class="font-semibold">Zitplaatsen:</span>
                    <span class="ml-2">{{ $car->seats }}</span>
                </div>
                @endif
                @if ($car->doors)
                <div>
                    <span class="font-semibold">Deuren:</span>
                    <span class="ml-2">{{ $car->doors }}</span>
                </div>
                @endif
                @if ($car->weight)
                <div>
                    <span class="font-semibold">Gewicht:</span>
                    <span class="ml-2">{{ $car->weight }} kg</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
