<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{ asset('css/error.css') }}">
<title>Page non trouvée</title>

</head>
<body>
<main>
<div class="container">
<h1>404</h1>
<p>Désolé, la page à l'aquelle vous tentez d'accéder n'existe pas. 😕</p>
<p><a href="{{ url('/accueil') }}" class="boutton">Retour à la page d'accueil</a></p>
</div>
</main>
</body>
</html>