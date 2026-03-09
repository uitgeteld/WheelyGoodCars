<x-layout>

    <div id="step1" class="flex flex-col items-center justify-center min-h-[calc(100vh-4rem)]">
        <div class="inline-flex items-stretch border-4 border-black rounded-xl overflow-hidden font-black shadow-2xl">
            <div class="bg-blue-800 text-white px-3 flex items-center text-2xl font-bold tracking-widest">
                NL
            </div>
            <input id="license_plate" type="text" placeholder="AA-BB-12"
                class="bg-yellow-400 border-none outline-none text-5xl font-black uppercase tracking-widest w-125 px-4 py-2 text-black text-center">
            <div class="bg-blue-800 text-white px-5 flex items-center text-2xl font-bold cursor-pointer hover:bg-blue-900" onclick="nextStep()">
                Go!
            </div>
        </div>
        <p id="step1-error" class="text-red-500 mt-4 text-lg" style="display:none"></p>
    </div>

    <div id="step2" style="display:none">
        <form method="POST" action="{{ route('cars.store') }}">
            @csrf
            <input type="hidden" name="license_plate" id="hidden-plate">

            <p>
                <label for="price">Prijs (€)</label><br>
                <input id="price" name="price" type="number" step="0.01" min="0" required>
            </p>

            <p>
                <label for="mileage">Kilometerstand</label><br>
                <input id="mileage" name="mileage" type="number" min="0" required>
            </p>

            <p>
                <button type="button" onclick="prevStep()">Terug</button>
                <button type="submit">Toevoegen</button>
            </p>
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
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = '';
        }

        function prevStep() {
            document.getElementById('step2').style.display = 'none';
            document.getElementById('step1').style.display = '';
        }
    </script>
</x-layout>