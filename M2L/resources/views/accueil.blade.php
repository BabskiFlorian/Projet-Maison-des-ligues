<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon/Maison_des_ligues_transparent-.png">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/acceuil.css">
    <title>Acceuil</title>
</head>
<body>
<header>
<div class="header-container">
    <h1>Acceuil</h1>
    <div class="profile-container">
        <a href="{{ url('/liste') }}" class="header-l">Liste</a>
        <a href="{{ url('/profil') }}">
            <img src="assets/profile/profile.png" alt="Photo de profil" class="profile-photo">
        </a>
        <a href="{{ url('/') }}" class="header-d">Déconnexion</a>
    </div>
</div>
</header>
<main>
    <div class="container">
        <div class="left">
        <h1>Bienvenue sur l'intranet</h1>
        <h2>Avez-vous dis bonjour à :<br>Nom + Prenom utilisateur</h2>
        <a  class="button">Dites bonjour à <br> quelqu'un d'autre</a>
    </div>
    <div class="right">
        <img src="../assets/profile/profile.png" alt="Photo de l'utilisateur" class="container-photo">
      </div>
    </div>
</main>
<footer>
    <p>Maison des ligues</p>
    <p>© 2025 Babski-Florian.</p>
  </footer>
</footer>
</body>
</html>