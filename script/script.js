const collaborateurs = [
    { nom: "Collaborateur 1", email: "email1@example.com", tel: "123-456-7890", anniversaire: "01/01" },
    { nom: "Collaborateur 2", email: "email2@example.com", tel: "987-654-3210", anniversaire: "02/02" },
    { nom: "Collaborateur 1", email: "email1@example.com", tel: "123-456-7890", anniversaire: "01/01" },
    { nom: "Collaborateur 2", email: "email2@example.com", tel: "987-654-3210", anniversaire: "02/02" },
    { nom: "Collaborateur 1", email: "email1@example.com", tel: "123-456-7890", anniversaire: "01/01" },
    { nom: "Collaborateur 2", email: "email2@example.com", tel: "987-654-3210", anniversaire: "02/02" },
    { nom: "Collaborateur 1", email: "email1@example.com", tel: "123-456-7890", anniversaire: "01/01" },
    { nom: "Collaborateur 2", email: "email2@example.com", tel: "987-654-3210", anniversaire: "02/02" },
    { nom: "Collaborateur 2", email: "email2@example.com", tel: "987-654-3210", anniversaire: "02/02" },];


const gridContainer = document.querySelector(".grid-container");

collaborateurs.forEach(collaborateur => {
    const card = document.createElement("div");
    card.classList.add("card");

    card.innerHTML = `
        <div class="photo"></div> 
        <h3>${collaborateur.nom}</h3>
        <p>Email: ${collaborateur.email}</p>
        <p>Tel: ${collaborateur.tel}</p>
        <p>Anniversaire: ${collaborateur.anniversaire}</p>
    `;

    gridContainer.appendChild(card);
});