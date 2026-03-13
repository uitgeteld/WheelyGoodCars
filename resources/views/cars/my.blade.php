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
                            <button type="button" data-id="{{ $car->id }}" class="status-toggle px-3 py-2 mb-2 {{ $car->sold_at ? 'bg-gray-600' : 'bg-red-600' }} hover:opacity-90 text-white text-sm rounded flex items-center gap-2" aria-pressed="{{ $car->sold_at ? 'true' : 'false' }}">
                                <span class="status-label">{{ $car->sold_at ? 'Beschikbaar' : 'Verkocht' }}</span>
                            </button>

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
    <script>
        (function(){
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

            function createSpinner(){
                const span = document.createElement('span');
                span.className = 'inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full';
                span.setAttribute('aria-hidden', 'true');
                span.style.animation = 'spin 0.8s linear infinite';
                return span;
            }

            function onToggleClick(e){
                const btn = e.currentTarget;
                const id = btn.getAttribute('data-id');
                if (!id) return;

                const label = btn.querySelector('.status-label');
                const spinner = createSpinner();
                btn.prepend(spinner);
                btn.disabled = true;

                fetch(`/cars/${id}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                }).then(r => r.json())
                .then(json => {
                    if (json.success) {
                        if (json.sold) {
                            label.textContent = 'Beschikbaar';
                            btn.classList.remove('bg-red-600');
                            btn.classList.add('bg-gray-600');
                            btn.setAttribute('aria-pressed', 'true');
                        } else {
                            label.textContent = 'Verkocht';
                            btn.classList.remove('bg-gray-600');
                            btn.classList.add('bg-red-600');
                            btn.setAttribute('aria-pressed', 'false');
                        }
                    } else {
                        alert(json.message || 'Er is iets misgegaan');
                    }
                }).catch(err => {
                    console.error(err);
                    alert('Er is iets misgegaan bij het bijwerken van de status.');
                }).finally(()=>{
                    btn.disabled = false;
                    spinner.remove();
                });
            }

            // small keyframes for spinner
            const style = document.createElement('style');
            style.textContent = '@keyframes spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}';
            document.head.appendChild(style);

            document.querySelectorAll('.status-toggle').forEach(btn => btn.addEventListener('click', onToggleClick));
        })();
    </script>
</x-layout>