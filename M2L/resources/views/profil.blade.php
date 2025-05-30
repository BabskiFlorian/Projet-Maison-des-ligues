<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="favicon/Maison_des_ligues_transparent-.png">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/profil.css">
    <title>Modifier mon compte</title>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Mon profil</h1>
            <div class="profile-container">
                <a href="{{ url('/accueil') }}" class="header-l">Accueil</a>
                <a href="{{ url('/liste') }}" class="header-l">Liste</a>
                <a href="{{ url('/profil') }}">
                    <img src="./assets/profile/profile.png" alt="Photo de profil"  class="profile-photo">
                </a>
                <a href="{{ url('/') }}" class="header-d">Déconnexion</a>
            </div>
        </div>
        </header>
        <main>

    <div class="container">
        <h1>Modifier mon compte</h1>
        <form id="profile-form">
            <div class="form-group">
                <label for="civility">Civilité :</label>
                <select id="civility" name="civility">
                    <option value="monsieur">Monsieur</option>
                    <option value="madame">Madame</option>
                    <option value="mademoiselle">Autre</option>
                </select>
            </div>

            <div class="form-group">
                <label for="category">Catégorie :</label>
                <select id="civility" name="civility">
                    <option value="technique">Développement</option>
                    <option value="marketing">Marketing</option>
                    <option value="vente">Vente</option>
                    <option value="rh">Ressources Humaines</option>
                    <option value="ihnformatique">Informatique</option>
                </select>
            </div>

            <div class="form-group">
                <label for="last-name">Nom :</label>
                <input type="text" id="last-name" name="last-name" value="" required>
            </div>

            <div class="form-group">
                <label for="first-name">Prénom :</label>
                <input type="text" id="first-name" name="first-name" value="" required>
            </div>

            <div class="form-group">
                <label for="email">Adresse e-mail :</label>
                <input type="email" id="email" name="email" value="" required>
            </div>

            <div class="form-group">
                <label for="new-password">Nouveau mot de passe* :</label>
                <input type="password" id="new-password" name="new-password">
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirmer le nouveau mot de passe* :</label>
                <input type="password" id="confirm-password" name="confirm-password">
            </div>

            <div class="form-group">
                <label for="phone">Téléphone :</label>
                <input type="tel" id="phone" name="phone" value="">
            </div>

            <div class="form-group">
                <label for="birth-date">Date de naissance :</label>
                <input type="date" id="birth-date" name="birth-date" value="">
            </div>

            <div class="form-group">
                <label for="city">Ville :</label>
                <input type="text" id="city" name="city" value="">
            </div>

            <div class="form-group">
                <label for="country">Pays :</label>
                <input type="text" id="country" name="country" value="">
            </div>

            <div class="form-group">
                <label for="photo-url">URL de la photo :</label>
                <input type="url" id="photo-url" name="photo-url" placeholder="https://...">
            </div>

            <button type="submit" class="button primary">Enregistrer les modifications</button>
            <button type="button" class="button secondary">Annuler</button>
        </form>
    </div>
    </main>
    <footer>
        <p>Maison des ligues</p>
        <p>© 2025 Babski-Florian.</p>
      </footer>
    </div>
</body>
</html>