<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon/Maison_des_ligues_transparent-.png">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/liste.css">
    <title>Liste</title>
</head>
<body>
<header>
<div class="header-container">
    <h1>Liste</h1>
    <div class="profile-container">
        <a href="{{ url('/accueil') }}" class="header-l">Acceuil</a>
        <a href="{{ url('/profil') }}">
            <img src="./assets/profile/profile.png" alt="Photo de profil" class="profile-photo">
        </a>
        <a href="{{ url('/') }}" class="header-d">Déconnexion</a>
    </div>
</div>
</header>
<main>
    <div class="container">
    <div class="search-filters">
        <input type="text" placeholder="Rechercher...">
        <label for="search-by">Rechercher par:</label>
        <select id="search-by">
            <option value="nom">Nom</option>
            <option value="prenom">Prenom</option>
            <option value="localisation">Localisation</option>
            <option value="categorie">Catégorie</option>
        </select>
        <label for="category-filter">Catégorie:</label>
        <select id="category-filter">
            <option value="toutes">Toutes</option>
            <option value="technique">Développement</option>
            <option value="marketing">Marketing</option>
            <option value="vente">Vente</option>
            <option value="rh">Ressources Humaines</option>
            <option value="ihnformatique">Informatique</option>
        </select>
    </div>
    <div class="grid-container"></div>
</div>


    <script src="script/script.js"></script>
    </div>
</main>
<footer>
    <p>Maison des ligues</p>
    <p>© 2025 Babski-Florian.</p>
  </footer>

</body>
</html>