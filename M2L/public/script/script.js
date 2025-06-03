document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchBySelect = document.getElementById('searchBySelect');
    const categoryFilterSelect = document.getElementById('categoryFilterSelect');
    const gridContainer = document.querySelector(".grid-container");
    const collaboratorCards = document.querySelectorAll('.collaborator-card'); // Récupère toutes les cartes générées par Blade
    const noCollaboratorsFound = document.getElementById('noCollaboratorsFound');

    function filterCollaborators() {
        const searchTerm = searchInput.value.toLowerCase();
        const searchBy = searchBySelect.value; // 'nom', 'prenom', 'ville', 'categorie'
        const selectedCategory = categoryFilterSelect.value; // 'toutes' ou une catégorie spécifique

        let visibleCardsCount = 0;

        collaboratorCards.forEach(card => {
            const nom = card.dataset.nom.toLowerCase();
            const prenom = card.dataset.prenom.toLowerCase();
            const ville = card.dataset.ville.toLowerCase(); // Utilisé pour 'localisation'
            const categorie = card.dataset.categorie.toLowerCase();

            let matchesSearch = false;
            let matchesCategory = false;

            // Vérifier la correspondance de recherche
            if (searchTerm === '') {
                matchesSearch = true; // Si le champ de recherche est vide, toutes les cartes correspondent
            } else {
                switch (searchBy) {
                    case 'nom':
                        matchesSearch = nom.includes(searchTerm);
                        break;
                    case 'prenom':
                        matchesSearch = prenom.includes(searchTerm);
                        break;
                    case 'ville': // 'localisation' correspond à 'ville'
                        matchesSearch = ville.includes(searchTerm);
                        break;
                    case 'categorie':
                        matchesSearch = categorie.includes(searchTerm);
                        break;
                }
            }

            // Vérifier la correspondance de catégorie
            if (selectedCategory === 'toutes') {
                matchesCategory = true; // Si 'Toutes' est sélectionné, toutes les catégories correspondent
            } else {
                matchesCategory = (categorie === selectedCategory.toLowerCase());
            }

            // Afficher ou masquer la carte en fonction des correspondances
            if (matchesSearch && matchesCategory) {
                card.style.display = ''; // Affiche la carte
                visibleCardsCount++;
            } else {
                card.style.display = 'none'; // Masque la carte
            }
        });

        // Afficher/masquer le message "Aucun collaborateur trouvé"
        if (visibleCardsCount === 0) {
            if (noCollaboratorsFound) { // Assurez-vous que l'élément existe si aucun collaborateur n'est là initialement
                noCollaboratorsFound.style.display = 'block';
                noCollaboratorsFound.textContent = 'Aucun collaborateur trouvé correspondant à votre recherche.';
            } else {
                // Si l'élément n'existe pas car il y avait des collaborateurs au début, créez-le
                const p = document.createElement('p');
                p.id = 'noCollaboratorsFound';
                p.textContent = 'Aucun collaborateur trouvé correspondant à votre recherche.';
                gridContainer.appendChild(p);
            }
        } else {
            if (noCollaboratorsFound) {
                noCollaboratorsFound.style.display = 'none';
            }
        }
    }

    // Attacher les écouteurs d'événements
    searchInput.addEventListener('keyup', filterCollaborators); // 'keyup' pour réagir à chaque frappe
    searchBySelect.addEventListener('change', filterCollaborators);
    categoryFilterSelect.addEventListener('change', filterCollaborators);

    // Exécuter le filtre initial au chargement de la page si les champs sont pré-remplis (non le cas ici)
    // filterCollaborators(); // Utile si vous avez des valeurs par défaut dans les filtres
});




        document.addEventListener('DOMContentLoaded', function() {
            const mainElement = document.querySelector('main');
            const parallaxStrength = 10; // valeur pour intensité

            if (mainElement) {
                mainElement.addEventListener('mousemove', (e) => {
                    const rect = mainElement.getBoundingClientRect();
                    const centerX = rect.left + rect.width / 2;
                    const centerY = rect.top + rect.height / 2;
                    const offsetX = e.clientX - centerX;
                    const offsetY = e.clientY - centerY;
                    const normalizedX = offsetX / rect.width;
                    const normalizedY = offsetY / rect.height;
                    
                    const backgroundPosX = -normalizedX * parallaxStrength;
                    const backgroundPosY = -normalizedY * parallaxStrength;

                    mainElement.style.backgroundPosition = `calc(50% + ${backgroundPosX}px) calc(50% + ${backgroundPosY}px)`;
                });
            }
        });

// public/script/script.js

// --- Code existant de recherche/filtrage (si applicable) ---
// S'assurer que le code de recherche/filtrage est ici si vous l'avez.
// Exemple (si vous l'avez) :
// document.addEventListener('DOMContentLoaded', function() {
//     const searchInput = document.getElementById('searchInput');
//     const searchBySelect = document.getElementById('searchBySelect');
//     const categoryFilterSelect = document.getElementById('categoryFilterSelect');
//     const collaboratorCards = document.querySelectorAll('.collaborator-card');
//     const noCollaboratorsFound = document.getElementById('noCollaboratorsFound');
//     const noCollaboratorsMessage = document.getElementById('noCollaboratorsMessage'); // Si présent

//     function filterCollaborators() {
//         // ... votre logique de filtrage ici ...
//     }

//     if (searchInput) searchInput.addEventListener('input', filterCollaborators);
//     if (searchBySelect) searchBySelect.addEventListener('change', filterCollaborators);
//     if (categoryFilterSelect) categoryFilterSelect.addEventListener('change', filterCollaborators);
// });


// --- Code pour la Modale de Confirmation de Suppression ---

// Récupérer les éléments de la modale LORSQUE LE DOM EST CHARGÉ
let customConfirmModal;
let modalConfirmBtn;
let modalCancelBtn;
let closeButton;
let confirmMessage;
let currentFormToSubmit = null; // Variable globale pour stocker le formulaire à soumettre

document.addEventListener('DOMContentLoaded', function() {
    customConfirmModal = document.getElementById('customConfirmModal');
    modalConfirmBtn = document.getElementById('modalConfirmBtn');
    modalCancelBtn = document.getElementById('modalCancelBtn');
    closeButton = customConfirmModal ? customConfirmModal.querySelector('.close-button') : null;
    confirmMessage = document.getElementById('confirmMessage');

    // Vérifier si les éléments de la modale existent avant d'ajouter les écouteurs
    if (customConfirmModal) {
        // Écouteurs d'événements pour fermer la modale
        if (modalCancelBtn) {
            modalCancelBtn.addEventListener('click', closeConfirmModal);
        }
        if (closeButton) {
            closeButton.addEventListener('click', closeConfirmModal);
        }

        // Fermer la modale si l'utilisateur clique en dehors du contenu
        window.addEventListener('click', (event) => {
            if (event.target === customConfirmModal) {
                closeConfirmModal();
            }
        });

        // Écouteur d'événement pour le bouton "Supprimer" de la modale
        if (modalConfirmBtn) {
            modalConfirmBtn.addEventListener('click', () => {
                if (currentFormToSubmit) {
                    // Désactiver le bouton original et changer le texte
                    const originalDeleteButton = currentFormToSubmit.querySelector('.delete-user-button');
                    if (originalDeleteButton) {
                        originalDeleteButton.disabled = true;
                        originalDeleteButton.textContent = 'Suppression...';
                    }
                    currentFormToSubmit.submit(); // Soumettre le formulaire stocké
                    closeConfirmModal(); // Fermer la modale
                }
            });
        }
    }
});


// Fonction pour ouvrir la modale (accessible globalement car non dans DOMContentLoaded)
function openConfirmModal(message, form) {
    // S'assurer que les éléments de la modale sont bien initialisés
    if (!customConfirmModal || !confirmMessage) {
        console.error("Erreur: Les éléments de la modale n'ont pas été trouvés. Assurez-vous que le HTML est correct et que le JS est chargé après le DOM.");
        return;
    }

    confirmMessage.textContent = message;
    currentFormToSubmit = form; // Stocker le formulaire
    customConfirmModal.style.display = 'flex'; // Afficher la modale
}

// Fonction pour fermer la modale (accessible globalement)
function closeConfirmModal() {
    if (!customConfirmModal) return;
    customConfirmModal.style.display = 'none'; // Cacher la modale
    currentFormToSubmit = null; // Réinitialiser le formulaire
}

// Nouvelle fonction qui sera appelée par le onsubmit du formulaire
function handleDeletion(event, userName) {
    event.preventDefault(); // Empêcher la soumission par défaut du formulaire

    const form = event.target; // Le formulaire qui a déclenché l'événement
    const message = `Êtes-vous sûr de vouloir supprimer ${userName} ? Cette action est irréversible.`;

    openConfirmModal(message, form); // Ouvrir la modale personnalisée
    return false; // Empêche la soumission normale du formulaire
}