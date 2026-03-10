<x-layout>

    <div id="step1" class="flex flex-col items-center justify-center min-h-[calc(100vh-4rem)]">
        <div class="inline-flex items-stretch border-4 border-black rounded-xl overflow-hidden font-black shadow-2xl">
            <div class="bg-blue-800 text-white px-2.5 flex items-center text-2xl font-bold tracking-widest">
                NL
            </div>
            <input id="license_plate" type="text" placeholder="AA-BB-12"
                class="bg-yellow-400 border-none outline-none text-4xl font-black uppercase tracking-widest w-125 px-4 py-3 text-black text-center">
            <div class="bg-blue-800 text-white px-5 flex items-center text-2xl font-bold cursor-pointer hover:bg-blue-900" onclick="nextStep()">
                Go!
            </div>
        </div>
        <p id="step1-error" class="text-red-500 mt-4 text-lg" style="display:none"></p>
    </div>

    <div id="step2" style="display:none" class="p-6">
        <h1 class="text-2xl font-bold mb-6">Nieuw aanbod</h1>

        <div class="mb-4 flex items-center gap-3">
            <div class="inline-flex items-stretch border-2 border-black rounded-md overflow-hidden font-black">
                <div class="bg-blue-800 text-white px-2 flex items-center text-sm font-bold tracking-widest">NL</div>
                <div id="display-plate" class="bg-yellow-400 text-2xl font-black uppercase tracking-widest w-40 px-3 py-1 text-black text-center"></div>
            </div>
        </div>

        <form method="POST" action="{{ route('cars.store') }}">
            @csrf
            <input type="hidden" name="license_plate" id="hidden-plate">

            <div class="mb-4">
                <label for="make" class="block font-semibold mb-1">Merk</label>
                <input id="make" name="make" type="text" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="model" class="block font-semibold mb-1">Model</label>
                <input id="model" name="model" type="text" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="seats" class="block font-semibold mb-1">Zitplaatsen</label>
                    <input id="seats" name="seats" type="number" min="1" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label for="doors" class="block font-semibold mb-1">Aantal deuren</label>
                    <input id="doors" name="doors" type="number" min="1" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label for="curbweight" class="block font-semibold mb-1">Massa rijklaar</label>
                    <input id="curbweight" name="curbweight" type="number" min="0" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="production-year" class="block font-semibold mb-1">Jaar van productie</label>
                    <input id="production-year" name="production_year" type="number" min="1886" max="{{ date('Y') }}" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label for="color" class="block font-semibold mb-1">Kleur</label>
                    <input id="color" name="color" type="text" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="mileage" class="block font-semibold mb-1">Kilometerstand</label>
                <input id="mileage" name="mileage" type="number" min="0" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label for="price" class="block font-semibold mb-1">Vraagprijs (€)</label>
                <input id="price" name="price" type="number" min="0" step="0.01" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="flex gap-2 mt-6">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Toevoegen</button>
            </div>
        </form>
    </div>

    <script>
        function nextStep() {
            var plate = document.getElementById('license_plate').value.trim();
            if (!plate) {
                document.getElementById('step1-error').textContent = 'Voer een kenteken in.';
                document.getElementById('step1-error').style.display = '';
                return;
            }
            document.getElementById('hidden-plate').value = plate;
            document.getElementById('display-plate').textContent = plate;
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = '';
        }

        function prevStep() {
            document.getElementById('step2').style.display = 'none';
            document.getElementById('step1').style.display = '';
        }
    </script>
</x-layout>