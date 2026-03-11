<x-layout>
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Mijn aanbod</h1>
        </div>

        @if ($cars->isEmpty())
        <p class="text-gray-500 text-center py-8">Je hebt nog geen auto's geplaatst.</p>
        @else
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border">
                <tbody>
                    @foreach ($cars as $car)
                    <tr class="border-b">
                        <td class="border text-center align-middle whitespace-nowrap w-px">
                            <div class="w-25 h-25 flex items-center justify-center text-gray-500">
                                @if ($car->image)
                                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->make }} {{ $car->model }}" class="w-full h-full object-cover rounded">
                                @else
                                <span class="text-sm">Geen afbeelding</span>
                                @endif
                            </div>
                        </td>

                        <td class="text-left align-middle whitespace-nowrap w-px px-6 font-semibold">
                            <a href="{{ route('cars.show', $car) }}">{{ $car->license_plate }}</a>
                        </td>

                        <td class=" text-left align-middle whitespace-nowrap w-px px-6 font-bold">
                            €{{ number_format($car->price, 2, ',', '.') }}
                        </td>

                        <td class="text-left align-middle w-full px-6 font-semibold">
                            {{ ucfirst($car->make) }} {{ strtoupper($car->model) }} {{ $car->production_year }}
                        </td>

                        <td class="text-center align-middle whitespace-nowrap w-px px-2">
                            <form action="{{ route('cars.destroy', $car) }}" method="POST" class="inline" onsubmit="return confirm('Weet je zeker dat je deze auto wilt verwijderen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-red-600 hover:bg-red-700 hover:cursor-pointer text-white text-sm">
                                    Verwijderen
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</x-layout>