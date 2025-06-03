<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon/Maison_des_ligues_transparent-.png">
    <link rel="stylesheet" href="{{ asset('./css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('./css/index.css') }}">
    <title>Connexion</title>
</head>
<body>
<header>
    <h1>Connexion</h1>
</header>
<main>
    <div class="container">
        <h1>Pour vous connecter à l'intranet entrez votre identifiant et mot de passe.</h1>
        <form method="POST" action="{{ route('login') }}" id="login-form">
            @csrf

            <div>
                <input type="email" id="email" name="email" placeholder="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <input type="password" id="password" name="password" placeholder="mot de passe" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit" class="button">Connexion</button>
            </div>

            <div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié ?') }}
                    </a>
                @endif
            </div>
        </form>
    </div>
</main>
<footer>
    <h1>Maison des ligues</h1>
    <p>© 2025 Babski-Florian.</p>
</footer>
<script src="{{ asset('script/script.js') }}"></script>
</body>
</html>