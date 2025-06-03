<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon/Maison_des_ligues_transparent-.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/acceuil.css') }}">
    <title>Accueil</title>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Accueil</h1>
    
            <div class="profile-container">
                <a href="{{ url('/liste') }}" class="header-l">Liste</a>
                <a href="{{ url('/profil') }}">
                    @if($loggedInUser && $loggedInUser->photo)
                        <img src="{{ $loggedInUser->photo }}" alt="Photo de profil" class="profile-photo">
                    @else
                        <img src="{{ asset('assets/profile/profile.png') }}" alt="Photo de l'utilisateur par défaut" class="container-photo">
                    @endif
                </a>
                @auth
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <a href="#" class="header-d" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Déconnexion
                </a>
                @endauth
            </div>
        </div>
    </header>
<main>
    <div class="container">
        <div class="left">
            <h1>Bienvenue sur l'intranet</h1>
            <h2>Avez-vous dit bonjour à :</h2><br>
            <h3>{{ $randomCollaborateur ? $randomCollaborateur->nom . ' ' . $randomCollaborateur->prenom : 'Aucun collaborateur trouvé...' }}</h3>
            <a class="button" href="{{ route('accueil') }}">Dites bonjour à <br> quelqu'un d'autre</a>
        </div>
        <div class="right">
            @if($randomCollaborateur && $randomCollaborateur->photo)
            <img src="{{ $randomCollaborateur->photo }}" alt="Photo de profil" class="profile-photo">            @else
            <img src="{{ asset('assets/profile/profile.png') }}" alt="Photo de l'utilisateur par défaut" class="container-photo">
            @endif
        </div>
    </div>
</main>
<footer>
    <h1>Maison des ligues</h1>
    <p>© 2025 Babski-Florian.</p>
</footer>
<script src="{{ asset('script/script.js') }}"></script>
</body>
</html>