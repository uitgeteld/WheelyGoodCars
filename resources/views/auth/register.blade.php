<x-layout>
    <h2>Account Aanmaken</h2>
    <p>Of <a href="{{ route('login') }}">log in met een bestaand account</a></p>

    @if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <p>
            <label for="name">Naam</label><br>
            <input id="name" name="name" type="text" autocomplete="name" required value="{{ old('name') }}" placeholder="Jan Jansen">
            @error('name') <br><span style="color:red">{{ $message }}</span> @enderror
        </p>

        <p>
            <label for="email">E-mailadres</label><br>
            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" placeholder="voorbeeld@email.com">
            @error('email') <br><span style="color:red">{{ $message }}</span> @enderror
        </p>

        <p>
            <label for="phone_number">Telefoonnummer</label><br>
            <input id="phone_number" name="phone_number" type="tel" autocomplete="tel" required value="{{ old('phone_number') }}" placeholder="06 12345678">
            @error('phone_number') <br><span style="color:red">{{ $message }}</span> @enderror
        </p>

        <p>
            <label for="password">Wachtwoord</label><br>
            <input id="password" name="password" type="password" autocomplete="new-password" required placeholder="Minimaal 8 tekens">
            @error('password') <br><span style="color:red">{{ $message }}</span> @enderror
        </p>

        <p>
            <label for="password_confirmation">Bevestig Wachtwoord</label><br>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required placeholder="Herhaal wachtwoord">
        </p>

        <p>
            <button type="submit">Registreren</button>
        </p>
    </form>
</x-layout>