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

    <script>
        setTimeout(() => {
            const views = "{{ $car->views }}"
            const message = views === 1 
                ? `${views} klant bekeek deze auto vandaag`
                : `${views} klanten bekeken deze auto vandaag`;
            
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center justify-between gap-4';
            toast.style.animation = 'fadeIn 0.3s ease-in';
            
            const messageSpan = document.createElement('span');
            messageSpan.textContent = message;
            
            const closeBtn = document.createElement('button');
            closeBtn.textContent = '✕';
            closeBtn.className = 'text-white text-lg font-bold hover:opacity-70 cursor-pointer';
            closeBtn.style.background = 'none';
            closeBtn.style.border = 'none';
            closeBtn.style.padding = '0';
            closeBtn.style.marginLeft = '8px';
            
            toast.appendChild(messageSpan);
            toast.appendChild(closeBtn);
            
            const style = document.createElement('style');
            style.textContent = `
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(10px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                @keyframes fadeOut {
                    from {
                        opacity: 1;
                        transform: translateY(0);
                    }
                    to {
                        opacity: 0;
                        transform: translateY(10px);
                    }
                }
            `;
            document.head.appendChild(style);
            document.body.appendChild(toast);

            let autoCloseTimeout = setTimeout(() => {
                toast.style.animation = 'fadeOut 0.3s ease-out forwards';
                setTimeout(() => toast.remove(), 300);
            }, 5000);

            closeBtn.addEventListener('click', () => {
                clearTimeout(autoCloseTimeout);
                toast.style.animation = 'fadeOut 0.3s ease-out forwards';
                setTimeout(() => toast.remove(), 300);
            });
        }, 10000);
    </script>
</x-layout>
