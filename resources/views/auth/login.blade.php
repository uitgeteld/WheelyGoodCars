<x-layout>
    <h2>Inloggen bij WheelyGoodCars</h2>
    <p>Of <a href="{{ route('register') }}">maak een nieuw account aan</a></p>

    @if ($errors->any())
    <p style="color:red">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <p>
            <label for="email">E-mailadres</label><br>
            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" placeholder="voorbeeld@email.com">
            @error('email') <br><span style="color:red">{{ $message }}</span> @enderror
        </p>

        <p>
            <label for="password">Wachtwoord</label><br>
            <input id="password" name="password" type="password" autocomplete="current-password" required placeholder="Wachtwoord">
            @error('password') <br><span style="color:red">{{ $message }}</span> @enderror
        </p>

        <p>
            <input id="remember" name="remember" type="checkbox">
            <label for="remember">Onthoud mij</label>
        </p>

        <p>
            <button type="submit">Inloggen</button>
        </p>
    </form>
</x-layout>