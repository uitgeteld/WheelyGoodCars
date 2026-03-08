@extends('layouts.guest')

@section('title', 'Registreren')

@section('content')
<div>
    <div>
        <div>
            <h2>Account Aanmaken</h2>
            <p>
                Of
                <a href="{{ route('login') }}">log in met een bestaand account</a>
            </p>
        </div>

        <div>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div>
                    <label for="name">Naam</label>
                    <div>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            autocomplete="name"
                            required
                            value="{{ old('name') }}"
                            placeholder="Jan Jansen">
                    </div>
                    @error('name')
                    <p>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email">E-mailadres</label>
                    <div>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            value="{{ old('email') }}"
                            placeholder="voorbeeld@email.com">
                    </div>
                    @error('email')
                    <p>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone_number">Telefoonnummer</label>
                    <div>
                        <input
                            id="phone_number"
                            name="phone_number"
                            type="tel"
                            autocomplete="tel"
                            required
                            value="{{ old('phone_number') }}"
                            placeholder="06 12345678">
                    </div>
                    @error('phone_number')
                    <p>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password">Wachtwoord</label>
                    <div>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            required
                            placeholder="password">
                    </div>
                    @error('password')
                    <p>{{ $message }}</p>
                    @enderror
                    <p>Minimaal 8 tekens</p>
                </div>

                <div>
                    <label for="password_confirmation">Bevestig Wachtwoord</label>
                    <div>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                            placeholder="password">
                    </div>
                </div>

                <div>
                    <button type="submit">Registreren</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection