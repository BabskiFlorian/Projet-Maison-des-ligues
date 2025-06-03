<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon/Maison_des_ligues_transparent-.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/liste.css') }}">
    <title>Liste des Collaborateurs</title>
</head>
<body>
<header>
    <div class="header-container">
        <h1>Liste</h1>

        <div class="profile-container">
            <a href="{{ url('/accueil') }}" class="header-l">Accueil</a>
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
        @auth
            @if(Auth::user()->isAdmin())
                <a href="{{ route('collaborateur.create') }}" class="button create-user-button">Créer un utilisateur</a>
            @endif
        @endauth

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="search-filters">
            <input type="text" id="searchInput" placeholder="Rechercher...">
            <label for="search-by">Rechercher par:</label>
            <select id="searchBySelect">
                <option value="nom">Nom</option>
                <option value="prenom">Prénom</option>
                <option value="ville">Ville</option>
                <option value="categorie">Catégorie</option>
            </select>
            <label for="category-filter">Catégorie:</label>
            <select id="categoryFilterSelect">
                <option value="toutes">Toutes</option>
                <option value="Développement">Développement</option>
                <option value="Marketing">Marketing</option>
                <option value="Vente">Vente</option>
                <option value="Ressources Humaines">Ressources Humaines</option>
                <option value="Informatique">Informatique</option>
            </select>
        </div>

        {{-- C'EST LA LIGNE MODIFIÉE : Ajoutez la classe 'grid-container' ici --}}
        <div class="grid-container"> 
            @forelse($collaborateurs as $collaborateur)
                <div class="collaborator-card"
                     data-nom="{{ $collaborateur->nom }}"
                     data-prenom="{{ $collaborateur->prenom }}"
                     data-ville="{{ $collaborateur->ville }}"
                     data-categorie="{{ $collaborateur->categorie }}">
                    @if($collaborateur->photo)
                        <img src="{{ $collaborateur->photo }}" alt="Photo de {{ $collaborateur->prenom }}" class="collaborator-photo">
                    @else
                        <img src="{{ asset('assets/profile/profile.png') }}" alt="Photo par défaut" class="collaborator-photo">
                    @endif
                    <h3>{{ $collaborateur->prenom }} {{ $collaborateur->nom }}</h3>
                    <p>Email: {{ $collaborateur->email }}</p>
                    <p>Téléphone: {{ $collaborateur->telephone ?? 'Non spécifié' }}</p>
                    <p>Anniversaire: {{ optional($collaborateur->date_de_naissance)->format('d/m/Y') ?? 'Non spécifié' }}</p>
                    <p>Catégorie: {{ $collaborateur->categorie ?? 'Non spécifié' }}</p>
                    <p>Ville: {{ $collaborateur->ville ?? 'Non spécifié' }}</p>
                    <p>Pays: {{ $collaborateur->pays ?? 'Non spécifié' }}</p>

{{-- À l'intérieur de la boucle @forelse et du @if(Auth::user()->isAdmin()) --}}
@auth
    @if(Auth::user()->isAdmin())
        <a href="{{ route('collaborateur.edit', $collaborateur->id_collaborateur) }}" class="button edit-user-button">Modifier</a>
        <form id="delete-form-{{ $collaborateur->id_collaborateur }}"
            action="{{ route('collaborateur.destroy', $collaborateur->id_collaborateur) }}"
            method="POST"
            style="display:inline-block;"
            onsubmit="return handleDeletion(event, '{{ $collaborateur->prenom }} {{ $collaborateur->nom }}')"> {{-- C'est cette ligne qui est cruciale --}}
          @csrf
          @method('DELETE')
          <button type="submit" class="button delete-user-button">
              Supprimer
          </button>
      </form>
    @endif
@endauth
                </div>
            @empty
                <p id="noCollaboratorsMessage" style="text-align: center; width: 100%;">Aucun collaborateur trouvé.</p>
            @endforelse

            <p id="noCollaboratorsFound" style="display: none; text-align: center; width: 100%;">Aucun collaborateur ne correspond aux filtres.</p>
        </div>
    </div>
</main>
<footer>
    <h1>Maison des ligues</h1>
    <p>© 2025 Babski-Florian.</p>
</footer>

<script src="{{ asset('script/script.js') }}"></script>
<div id="customConfirmModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2>Confirmer la suppression</h2>
        <p id="confirmMessage">Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.</p>
        <div class="modal-actions">
            <button id="modalConfirmBtn" class="button delete-user-button">Supprimer</button>
            <button id="modalCancelBtn" class="button cancel-button">Annuler</button>
        </div>
    </div>
</div>
</body>
</html>