@extends('layouts.app')

@section('title', 'Mijn Auto\'s')

@section('content')
<div>
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Mijn Auto's</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Beheer je aangeboden auto's</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('cars.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Auto Toevoegen
            </a>
        </div>
    </div>

    @if($cars->isEmpty())
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Nog geen auto's toegevoegd</h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Voeg je eerste auto toe om te beginnen met verkopen</p>
            <div class="mt-6">
                <a href="{{ route('cars.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out">
                    Auto Toevoegen
                </a>
            </div>
        </div>
    @else
        <!-- Desktop Table View -->
        <div class="hidden lg:block bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Kenteken
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Auto
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Bouwjaar
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Kilometerstand
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Prijs
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Acties
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($cars as $car)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $car->license_plate }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $car->make }} {{ $car->model }}
                                </div>
                                @if($car->color)
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $car->color }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ $car->production_year ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ number_format($car->mileage, 0, ',', '.') }} km
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                    € {{ number_format($car->price, 2, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($car->sold_at)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        Verkocht
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        Actief
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('cars.show', $car) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        Bekijk
                                    </a>
                                    <a href="{{ route('cars.edit', $car) }}" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                        Bewerk
                                    </a>
                                    <button 
                                        onclick="confirmDelete({{ $car->id }}, '{{ $car->license_plate }}')"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                    >
                                        Verwijder
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View -->
        <div class="lg:hidden space-y-4">
            @foreach($cars as $car)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $car->make }} {{ $car->model }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $car->license_plate }}
                            </div>
                        </div>
                        @if($car->sold_at)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                Verkocht
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                Actief
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Bouwjaar:</span>
                            <span class="font-medium text-gray-900 dark:text-white ml-1">
                                {{ $car->production_year ?? '-' }}
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-600 dark:text-gray-400">Km-stand:</span>
                            <span class="font-medium text-gray-900 dark:text-white ml-1">
                                {{ number_format($car->mileage, 0, ',', '.') }}
                            </span>
                        </div>
                        @if($car->color)
                            <div class="col-span-2">
                                <span class="text-gray-600 dark:text-gray-400">Kleur:</span>
                                <span class="font-medium text-gray-900 dark:text-white ml-1">
                                    {{ $car->color }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-4">
                        € {{ number_format($car->price, 2, ',', '.') }}
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('cars.show', $car) }}" class="flex-1 text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-150">
                            Bekijk
                        </a>
                        <a href="{{ route('cars.edit', $car) }}" class="flex-1 text-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition duration-150">
                            Bewerk
                        </a>
                        <button 
                            onclick="confirmDelete({{ $car->id }}, '{{ $car->license_plate }}')"
                            class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition duration-150"
                        >
                            Verwijder
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 dark:bg-gray-900 dark:bg-opacity-75 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/30">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Auto Verwijderen
                </h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Weet je zeker dat je <strong id="deleteCarPlate" class="text-gray-900 dark:text-white"></strong> wilt verwijderen? Deze actie kan niet ongedaan worden gemaakt.
                    </p>
                </div>
                <div class="flex gap-3 px-4 py-3">
                    <button 
                        onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg transition duration-150"
                    >
                        Annuleren
                    </button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit"
                            class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition duration-150"
                        >
                            Verwijderen
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(carId, licensePlate) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const plateSpan = document.getElementById('deleteCarPlate');
    
    plateSpan.textContent = licensePlate;
    form.action = `/cars/${carId}`;
    
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>
@endsection
