@extends('layouts.app')

@section('title', 'Auto Toevoegen')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Auto Toevoegen</h1>

    <!-- Step 1: License Plate Input -->
    <div id="step1" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Stap 1: Voer Kenteken In</h2>
        
        <div class="space-y-4">
            <div>
                <label for="license_plate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Kenteken
                </label>
                <input 
                    type="text" 
                    id="license_plate" 
                    name="license_plate"
                    placeholder="bijv. XX-123-X"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white uppercase"
                >
                <p id="plate-error" class="mt-2 text-sm text-red-600 dark:text-red-400 hidden"></p>
            </div>

            <button 
                type="button" 
                id="checkPlateBtn"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span id="checkBtnText">Kenteken Controleren</span>
                <span id="checkBtnLoading" class="hidden">
                    <svg class="inline animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Bezig met controleren...
                </span>
            </button>
        </div>
    </div>

    <!-- Step 2: Vehicle Details & Price (Hidden Initially) -->
    <div id="step2" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mt-6 hidden">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Stap 2: Controleer Gegevens & Voer Prijs In</h2>

        <form action="{{ route('cars.store') }}" method="POST">
            @csrf

            <!-- Vehicle Data Display -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Voertuig Gegevens</h3>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Kenteken:</span>
                        <span id="display-plate" class="font-medium text-gray-900 dark:text-white ml-2"></span>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Merk:</span>
                        <span id="display-make" class="font-medium text-gray-900 dark:text-white ml-2"></span>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Model:</span>
                        <span id="display-model" class="font-medium text-gray-900 dark:text-white ml-2"></span>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Bouwjaar:</span>
                        <span id="display-year" class="font-medium text-gray-900 dark:text-white ml-2"></span>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Kleur:</span>
                        <span id="display-color" class="font-medium text-gray-900 dark:text-white ml-2"></span>
                    </div>
                    <div>
                        <span class="text-gray-600 dark:text-gray-400">Zitplaatsen:</span>
                        <span id="display-seats" class="font-medium text-gray-900 dark:text-white ml-2"></span>
                    </div>
                </div>
            </div>

            <!-- Hidden fields to submit vehicle data -->
            <input type="hidden" name="license_plate" id="hidden-plate">
            <input type="hidden" name="make" id="hidden-make">
            <input type="hidden" name="model" id="hidden-model">
            <input type="hidden" name="production_year" id="hidden-year">
            <input type="hidden" name="color" id="hidden-color">
            <input type="hidden" name="seats" id="hidden-seats">
            <input type="hidden" name="doors" id="hidden-doors">
            <input type="hidden" name="weight" id="hidden-weight">

            <!-- Price Input -->
            <div class="space-y-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Vraagprijs *
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500 dark:text-gray-400">€</span>
                        <input 
                            type="number" 
                            id="price" 
                            name="price"
                            step="0.01"
                            min="0"
                            required
                            placeholder="15000.00"
                            class="w-full pl-8 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        >
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="mileage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Kilometerstand *
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="mileage" 
                            name="mileage"
                            min="0"
                            required
                            placeholder="125000"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                        >
                        <span class="absolute right-3 top-2 text-gray-500 dark:text-gray-400">km</span>
                    </div>
                    @error('mileage')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 mt-6">
                <button 
                    type="button" 
                    id="backBtn"
                    class="flex-1 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium py-3 px-4 rounded-lg transition duration-150 ease-in-out"
                >
                    Terug
                </button>
                <button 
                    type="submit"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition duration-150 ease-in-out"
                >
                    Auto Toevoegen
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const licensePlateInput = document.getElementById('license_plate');
    const checkPlateBtn = document.getElementById('checkPlateBtn');
    const checkBtnText = document.getElementById('checkBtnText');
    const checkBtnLoading = document.getElementById('checkBtnLoading');
    const plateError = document.getElementById('plate-error');
    const backBtn = document.getElementById('backBtn');

    checkPlateBtn.addEventListener('click', async function() {
        const licensePlate = licensePlateInput.value.trim().toUpperCase();
        
        if (!licensePlate) {
            showError('Voer een kenteken in');
            return;
        }

        // Show loading state
        checkPlateBtn.disabled = true;
        checkBtnText.classList.add('hidden');
        checkBtnLoading.classList.remove('hidden');
        plateError.classList.add('hidden');

        try {
            const response = await fetch(`{{ route('cars.checkKenteken') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ license_plate: licensePlate })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Populate step 2 with vehicle data
                populateVehicleData(data.data);
                
                // Hide step 1, show step 2
                step1.classList.add('hidden');
                step2.classList.remove('hidden');
            } else {
                showError(data.message || 'Er is een fout opgetreden');
            }
        } catch (error) {
            console.error('Fetch error:', error);
            showError('Kan geen verbinding maken met de server. Controleer je internetverbinding.');
        } finally {
            // Reset button state
            checkPlateBtn.disabled = false;
            checkBtnText.classList.remove('hidden');
            checkBtnLoading.classList.add('hidden');
        }
    });

    backBtn.addEventListener('click', function() {
        step2.classList.add('hidden');
        step1.classList.remove('hidden');
        licensePlateInput.focus();
    });

    function populateVehicleData(vehicle) {
        // Display fields
        document.getElementById('display-plate').textContent = vehicle.license_plate || '-';
        document.getElementById('display-make').textContent = vehicle.make || '-';
        document.getElementById('display-model').textContent = vehicle.model || '-';
        document.getElementById('display-year').textContent = vehicle.production_year || '-';
        document.getElementById('display-color').textContent = vehicle.color || '-';
        document.getElementById('display-seats').textContent = vehicle.seats || '-';

        // Hidden form fields
        document.getElementById('hidden-plate').value = vehicle.license_plate || '';
        document.getElementById('hidden-make').value = vehicle.make || '';
        document.getElementById('hidden-model').value = vehicle.model || '';
        document.getElementById('hidden-year').value = vehicle.production_year || '';
        document.getElementById('hidden-color').value = vehicle.color || '';
        document.getElementById('hidden-seats').value = vehicle.seats || '';
        document.getElementById('hidden-doors').value = vehicle.doors || '';
        document.getElementById('hidden-weight').value = vehicle.weight || '';
    }

    function showError(message) {
        plateError.textContent = message;
        plateError.classList.remove('hidden');
    }

    // Allow Enter key to trigger check
    licensePlateInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            checkPlateBtn.click();
        }
    });
});
</script>
@endsection
