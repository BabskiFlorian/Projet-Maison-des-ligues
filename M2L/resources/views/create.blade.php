<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon/Maison_des_ligues_transparent-.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/create.css') }}"> 
    <title>Créer un nouvel utilisateur</title>
</head>
<body>
<header>
    <div class="header-container">
        <h1>Créer un utilisateur</h1>
        <div class="profile-container">
            <a href="{{ url('/accueil') }}" class="header-l">Accueil</a>
            <a href="{{ url('/liste') }}" class="header-l">Liste</a>
            <a href="{{ url('/profil') }}">
                @if($loggedInUser && $loggedInUser->photo)
                <img src="{{ $loggedInUser ? $loggedInUser->photo : asset('assets/profile/profile.png') }}" alt="Photo de profil" class="profile-photo">
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
    <div class="form-container">
        <h2>Formulaire de création d'utilisateur</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('collaborateur.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Mot de passe:</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <div class="form-group">
                <label for="mot_de_passe_confirmation">Confirmer le mot de passe:</label>
                <input type="password" id="mot_de_passe_confirmation" name="mot_de_passe_confirmation" required>
            </div>

            <div class="form-group">
                <label for="civilite">Civilité:</label>
                <select id="civilite" name="civilite">
                    <option value="">Sélectionner</option>
                    <option value="Monsieur" {{ old('civilite') == 'Monsieur' ? 'selected' : '' }}>Monsieur</option>
                    <option value="Madame" {{ old('civilite') == 'Madame' ? 'selected' : '' }}>Madame</option>
                    <option value="Autre" {{ old('civilite') == 'Autre' ? 'selected' : '' }}>Autre</option>
                </select>
            </div>

            <div class="form-group">
                <label for="categorie">Catégorie:</label>
                <select id="categorie" name="categorie">
                    <option value="">Sélectionner</option>
                    <option value="Développement" {{ old('categorie') == 'Développement' ? 'selected' : '' }}>Développement</option>
                    <option value="Marketing" {{ old('categorie') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="Vente" {{ old('categorie') == 'Vente' ? 'selected' : '' }}>Vente</option>
                    <option value="Ressources Humaines" {{ old('categorie') == 'Ressources Humaines' ? 'selected' : '' }}>Ressources Humaines</option>
                    <option value="Informatique" {{ old('categorie') == 'Informatique' ? 'selected' : '' }}>Informatique</option>
                </select>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone:</label>
                <input type="text" id="telephone" name="telephone" value="{{ old('telephone') }}">
            </div>

            <div class="form-group">
                <label for="date_de_naissance">Date de naissance:</label>
                <input type="date" id="date_de_naissance" name="date_de_naissance" value="{{ old('date_de_naissance') }}">
            </div>

            <div class="form-group">
                <label for="ville">Ville:</label>
                <input type="text" id="ville" name="ville" value="{{ old('ville') }}">
            </div>

            <div class="form-group">
                <label for="pays">Pays:</label>
                <input type="text" id="pays" name="pays" value="{{ old('pays') }}">
            </div>

            <div class="form-group">
                <label for="photo">URL de la photo de profil:</label>
                <input type="url" id="photo" name="photo" value="{{ old('photo') }}"> 
            </div>
        

            <div class="form-group checkbox-group">
                <input type="checkbox" id="est_admin" name="est_admin" value="1" {{ old('est_admin') ? 'checked' : '' }}>
                <label for="est_admin">Est administrateur</label>
            </div>

            <button type="submit" class="create-user-button">Créer l'utilisateur</button>
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