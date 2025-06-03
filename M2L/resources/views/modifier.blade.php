<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon/Maison_des_ligues_transparent-.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
    {{-- Mise à jour du titre pour la modification --}}
    <title>Modifier l'utilisateur</title>
</head>
<body>
<header>
    <div class="header-container">
        {{-- Mise à jour du titre du header --}}
        <h1>Modifier l'utilisateur</h1>
        <div class="profile-container">
            <a href="{{ url('/accueil') }}" class="header-l">Accueil</a>
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
    <div class="form-container">
        {{-- Mise à jour du titre du formulaire --}}
        <h2>Modifier les informations de l'utilisateur</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Affichage du message de succès si la modification a réussi --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        {{-- IMPORTANT : Changement de l'action du formulaire et de la méthode --}}
        <form action="{{ route('collaborateur.update', $collaborateur->id_collaborateur) }}" method="POST">
            @csrf
            @method('PUT') {{-- C'est crucial pour indiquer que c'est une requête de mise à jour --}}

            <div class="form-group">
                <label for="nom">Nom:</label>
                {{-- Pré-remplir avec les données existantes du collaborateur --}}
                <input type="text" id="nom" name="nom" value="{{ old('nom', $collaborateur->nom) }}" required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom:</label>
                {{-- Pré-remplir --}}
                <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $collaborateur->prenom) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                {{-- Pré-remplir --}}
                <input type="email" id="email" name="email" value="{{ old('email', $collaborateur->email) }}" required>
            </div>

            {{-- IMPORTANT : Les champs mot_de_passe et mot_de_passe_confirmation
                          ne doivent pas être 'required' pour une modification normale
                          sauf si l'utilisateur veut explicitement changer le mot de passe.
                          Je les retire ou les rends optionnels. --}}
            {{-- Si vous voulez un champ de changement de mot de passe, il doit être vide par défaut
                 et n'être 'required' que si l'utilisateur le remplit. --}}
            <div class="form-group">
                <label for="mot_de_passe">Nouveau mot de passe (laisser vide si inchangé):</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe">
            </div>

            <div class="form-group">
                <label for="mot_de_passe_confirmation">Confirmer le nouveau mot de passe:</label>
                <input type="password" id="mot_de_passe_confirmation" name="mot_de_passe_confirmation">
            </div>
            {{-- Fin des ajustements pour le mot de passe --}}


            <div class="form-group">
                <label for="civilite">Civilité:</label>
                <select id="civilite" name="civilite">
                    <option value="">Sélectionner</option>
                    {{-- Pré-sélectionner la valeur existante --}}
                    <option value="Monsieur" {{ old('civilite', $collaborateur->civilite) == 'Monsieur' ? 'selected' : '' }}>Monsieur</option>
                    <option value="Madame" {{ old('civilite', $collaborateur->civilite) == 'Madame' ? 'selected' : '' }}>Madame</option>
                    <option value="Autre" {{ old('civilite', $collaborateur->civilite) == 'Autre' ? 'selected' : '' }}>Autre</option>
                </select>
            </div>

            <div class="form-group">
                <label for="categorie">Catégorie:</label>
                <select id="categorie" name="categorie">
                    <option value="">Sélectionner</option>
                    {{-- Pré-sélectionner --}}
                    <option value="Développement" {{ old('categorie', $collaborateur->categorie) == 'Développement' ? 'selected' : '' }}>Développement</option>
                    <option value="Marketing" {{ old('categorie', $collaborateur->categorie) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                    <option value="Vente" {{ old('categorie', $collaborateur->categorie) == 'Vente' ? 'selected' : '' }}>Vente</option>
                    <option value="Ressources Humaines" {{ old('categorie', $collaborateur->categorie) == 'Ressources Humaines' ? 'selected' : '' }}>Ressources Humaines</option>
                    <option value="Informatique" {{ old('categorie', $collaborateur->categorie) == 'Informatique' ? 'selected' : '' }}>Informatique</option>
                </select>
            </div>

            <div class="form-group">
                <label for="telephone">Téléphone:</label>
                {{-- Pré-remplir --}}
                <input type="text" id="telephone" name="telephone" value="{{ old('telephone', $collaborateur->telephone) }}">
            </div>

            <div class="form-group">
                <label for="date_de_naissance">Date de naissance:</label>
                {{-- Pré-remplir (format YYYY-MM-DD pour les input type="date") --}}
                <input type="date" id="date_de_naissance" name="date_de_naissance" value="{{ old('date_de_naissance', optional($collaborateur->date_de_naissance)->format('Y-m-d')) }}">
            </div>

            <div class="form-group">
                <label for="ville">Ville:</label>
                {{-- Pré-remplir --}}
                <input type="text" id="ville" name="ville" value="{{ old('ville', $collaborateur->ville) }}">
            </div>

            <div class="form-group">
                <label for="pays">Pays:</label>
                {{-- Pré-remplir --}}
                <input type="text" id="pays" name="pays" value="{{ old('pays', $collaborateur->pays) }}">
            </div>

            <div class="form-group">
                <label for="photo">URL de la photo de profil:</label>
                {{-- Pré-remplir l'URL de la photo existante --}}
                <input type="url" id="photo" name="photo" value="{{ old('photo', $collaborateur->photo) }}">
                @if($collaborateur->photo)
                    <p>Photo actuelle: <img src="{{ $collaborateur->photo }}" alt="Photo actuelle" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-top: 10px;"></p>
                @endif
            </div>

            <div class="form-group checkbox-group">
                {{-- Pré-cochez si l'utilisateur est admin --}}
                <input type="checkbox" id="est_admin" name="est_admin" value="1" {{ old('est_admin', $collaborateur->est_admin) ? 'checked' : '' }}>
                <label for="est_admin">Est administrateur</label>
            </div>

            {{-- Mise à jour du texte du bouton --}}
            <button type="submit" class="create-user-button">Mettre à jour l'utilisateur</button>
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