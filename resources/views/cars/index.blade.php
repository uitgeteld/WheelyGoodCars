<x-layout>
    <div class="p-6">
        <h1 class="text-3xl font-bold mb-6">Alle auto's</h1>

        @if ($cars->isEmpty())
            <p class="text-gray-500 text-center py-8">Er zijn nog geen auto's geplaatst.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b-2 border-b-black">
                            <th class="text-left p-3 font-semibold">Afbeelding</th>
                            <th class="text-left p-3 font-semibold">Kenteken</th>
                            <th class="text-left p-3 font-semibold">Auto</th>
                            <th class="text-left p-3 font-semibold">Vraagprijs</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cars as $car)
                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                <td class="p-3">
                                    <div class="w-24 h-24 bg-gray-300 rounded flex items-center justify-center text-gray-500">
                                        @if ($car->image)
                                            <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}" class="w-full h-full object-cover rounded">
                                        @else
                                            <span class="text-sm">Geen afbeelding</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="p-3">
                                    <div class="inline-flex items-stretch border-2 border-black rounded overflow-hidden font-black">
                                        <div class="bg-blue-800 text-white px-1.5 flex items-center text-xs font-bold tracking-widest">NL</div>
                                        <div class="bg-yellow-400 text-xl font-black uppercase tracking-widest px-2 py-1 text-black">
                                            {{ $car->license_plate }}
                                        </div>
                                    </div>
                                </td>

                                <td class="p-3">
                                    <div class="font-semibold">{{ $car->make }} {{ $car->model }}</div>
                                    <div class="text-sm text-gray-600">{{ $car->production_year }}</div>
                                </td>

                                <td class="p-3">
                                    € {{ number_format($car->price, 2, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layout>
