<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon/Maison_des_ligues_transparent-.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profil.css') }}">
    <title>Modifier mon compte</title>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Mon profil</h1>
            <div class="profile-container">
                <a href="{{ url('/accueil') }}" class="header-l">Accueil</a>
                <a href="{{ url('/liste') }}" class="header-l">Liste</a>
                <a href="{{ route('collaborateur.edit_profile') }}">
                    @if($collaborateur && $collaborateur->photo)
                        <img src="{{ $collaborateur->photo }}" alt="Photo de profil" class="profile-photo">
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
            <h1>Modifier mon compte</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('collaborateur.update_profile') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="civilite">Civilité :</label>
                    <select id="civilite" name="civilite">
                        <option value="">Sélectionner</option>
                        <option value="Homme" {{ old('civilite', $collaborateur->civilite) == 'Homme' ? 'selected' : '' }}>Homme</option>
                        <option value="Femme" {{ old('civilite', $collaborateur->civilite) == 'Femme' ? 'selected' : '' }}>Femme</option>
                        <option value="Autre" {{ old('civilite', $collaborateur->civilite) == 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('civilite') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="categorie">Catégorie :</label>
                    <select id="categorie" name="categorie">
                        <option value="">Sélectionner</option>
                        <option value="Développement" {{ old('categorie', $collaborateur->categorie) == 'Développement' ? 'selected' : '' }}>Développement</option>
                        <option value="Marketing" {{ old('categorie', $collaborateur->categorie) == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="Vente" {{ old('categorie', $collaborateur->categorie) == 'Vente' ? 'selected' : '' }}>Vente</option>
                        <option value="Ressources Humaines" {{ old('categorie', $collaborateur->categorie) == 'Ressources Humaines' ? 'selected' : '' }}>Ressources Humaines</option>
                        <option value="Informatique" {{ old('categorie', $collaborateur->categorie) == 'Informatique' ? 'selected' : '' }}>Informatique</option>
                    </select>
                    @error('categorie') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $collaborateur->nom) }}" required>
                    @error('nom') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $collaborateur->prenom) }}" required>
                    @error('prenom') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Adresse e-mail :</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $collaborateur->email) }}" required>
                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <hr>

                <h2>Changer le mot de passe (optionnel)</h2>

                <div class="form-group">
                    <label for="current_password">Mot de passe actuel :</label>
                    <input type="password" id="current_password" name="current_password">
                    @error('current_password') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="mot_de_passe">Nouveau mot de passe :</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe">
                    @error('mot_de_passe') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="mot_de_passe_confirmation">Confirmer le nouveau mot de passe :</label>
                    <input type="password" id="mot_de_passe_confirmation" name="mot_de_passe_confirmation">
                </div>

                <hr>

                <div class="form-group">
                    <label for="telephone">Téléphone :</label>
                    <input type="tel" id="telephone" name="telephone" value="{{ old('telephone', $collaborateur->telephone) }}">
                    @error('telephone') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="date_de_naissance">Date de naissance :</label>
                    <input type="date" id="date_de_naissance" name="date_de_naissance" value="{{ old('date_de_naissance', optional($collaborateur->date_de_naissance)->format('Y-m-d')) }}">
                    @error('date_de_naissance') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="ville">Ville :</label>
                    <input type="text" id="ville" name="ville" value="{{ old('ville', $collaborateur->ville) }}">
                    @error('ville') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="pays">Pays :</label>
                    <input type="text" id="pays" name="pays" value="{{ old('pays', $collaborateur->pays) }}">
                    @error('pays') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="photo">URL de la photo de profil :</label> {{-- Type text ou url --}}
                    <input type="url" id="photo" name="photo" value="{{ old('photo', $collaborateur->photo) }}" placeholder="Ex: https://example.com/ma-photo.jpg">
                    @if($collaborateur->photo)
                        {{-- Affiche la photo actuelle en utilisant l'URL directement --}}
                        <img src="{{ $collaborateur->photo }}" alt="Photo de profil actuelle" class="photo-bas">
                    @endif
                    @error('photo') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="button primary">Enregistrer les modifications</button>
                <button type="button" class="button secondary" onclick="window.location='{{ route('accueil') }}'">Annuler</button>
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