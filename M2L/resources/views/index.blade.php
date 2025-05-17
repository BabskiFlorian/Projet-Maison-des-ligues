<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon/Maison_des_ligues_transparent-.png">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/index.css">
    <title>Connexion</title>
</head>
<body>
<header>
<h1>Connexion</h1>
</header>
<main>
    <div class="container">
        <h1>Pour vous connecter à l'intranet entrez identifiant et mot de passe.</h1>
        <form id="login-form">
            <input type="email" id="email" name="email" placeholder="email" required>
            <input type="password" id="password" name="password" placeholder="mot de passe" required>
            <a href="{{ url('/accueil') }}" class="button">Connexion</a>
        </form>
    </div>
</main>
<footer>
    <p>Maison des ligues</p>
    <p>© 2025 Babski-Florian.</p>
  </footer>
</footer>
</body>
</html>