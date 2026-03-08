@extends('layouts.guest')

@section('title', 'Inloggen')

@section('content')
<div>
    <div>
        <div>
            <h2>Inloggen bij WheelyGoodCars</h2>
            <p>
                Of
                <a href="{{ route('register') }}>maak een nieuw account aan</a>
            </p>
        </div>

        <div>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                @if ($errors->any())
                    <div>
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

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
                            placeholder="voorbeeld@email.com"
                        >
                    </div>
                    @error('email')
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
                            autocomplete="current-password" 
                            required 
                            placeholder="password"
                        >
                    </div>
                    @error('password')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div>
                        <input id="remember" name="remember" type="checkbox">
                        <label for="remember">Onthoud mij</label>
                    </div>

                    <div>
                        <a href="#">Wachtwoord vergeten?</a>
                    </div>
                </div>

                <div>
                    <button type="submit">Inloggen</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
