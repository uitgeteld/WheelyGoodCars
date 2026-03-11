<x-layout>
    <div class="p-6">
        <h1 class="text-3xl font-bold mb-6">Alle auto's</h1>

        @if ($cars->isEmpty())
        <p class="text-gray-500 text-center py-8">Er zijn nog geen auto's geplaatst.</p>
        @else
        <div class="grid grid-cols-4 gap-4">
            @foreach ($cars as $car)
            <a href="{{ route('cars.show', $car) }}" class="block border rounded-xs p-4 shadow hover:shadow-lg transition">
                <div class="inline-flex items-stretch rounded-md overflow-hidden font-black mb-4">
                    @if ($car->image)
                    <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}" class="w-full h-full object-cover rounded">
                    @else
                    <span class="text-sm">Geen afbeelding</span>
                    @endif
                </div>
                <h2 class="text-lg font-semibold">{{ $car->make }} {{ $car->model }}</h2>
                <p class="text-sm text-gray-600 font-semibold mb-2">{{ $car->production_year }}</p>
                <h3 class="font-bold"> €{{ number_format($car->price, 2, ',', '.') }}</h3>
                <p class="text-gray-800 mb-1">{{ $car->mileage }}km</p>

            </a>
            @endforeach
        </div>
        @endif
</x-layout>