import requests
import csv

def generer_utilisateurs_random(nombre_utilisateurs):
    url = f"https://api.randomuser.me/?results={nombre_utilisateurs}&nat=fr"

    try:
        reponse = requests.get(url)
        reponse.raise_for_status()
        data = reponse.json()

        genre_mapping = {
            "male": "Monsieur",
            "female": "Madame",
        }

        utilisateurs = []

        for user in data['results']:
            utilisateur = {
                "civilite": genre_mapping.get(user['gender'], "Inconnu"),
                "prenom": user['name']['first'],
                "nom": user['name']['last'],
                "email": user['email'],
                "telephone": user['phone'],
                "photo": user['picture']['medium'],
                "mot_de_passe": "motdepasse"
            }
            utilisateurs.append(utilisateur)

        return utilisateurs

    except requests.exceptions.RequestException:
        print("Erreur lors de l'appel à l'API.")
        return []

def enregistrer_en_csv(donnees, nom_fichier="utilisateurs.csv"):
    if not donnees:
        print("Aucune donnée à enregistrer.")
        return False

    champs = list(donnees[0].keys())

    try:
        with open(nom_fichier, 'w', newline='', encoding='utf-8') as fichier_csv:
            writer = csv.DictWriter(fichier_csv, fieldnames=champs)
            writer.writeheader()
            writer.writerows(donnees)
        return True
    except IOError:
        print("Erreur lors de l'écriture du fichier CSV.")
        return False

if __name__ == "__main__":
    NOMBRE_A_GENERER = 5
    utilisateurs = generer_utilisateurs_random(NOMBRE_A_GENERER)

    if utilisateurs and enregistrer_en_csv(utilisateurs, "liste_utilisateurs.csv"):
        print("Script terminé avec succès.")
    else:
        print("Le script n'a pas fonctionné correctement.")
