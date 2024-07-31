
/*FILTRAGE DES TRAVAUX AU CLIC SUR LA CATEGORIE*/
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.filter-category').forEach(function(element) {
        element.addEventListener('click', function() {
            var category = this.getAttribute('data-category');

            fetch('/filter?category=' + category)
                .then(response => response.json())
                .then(data => {
                    var worksList = document.getElementById('works-list');
                    worksList.innerHTML = '';

                    data.works.forEach(function(work) {
                        var workCard = document.createElement('div');
                        workCard.classList.add('work-card');

                        var img = document.createElement('img');
                        img.classList.add('work-image');
                        img.src = './uploads/images/' + work.image;
                        workCard.appendChild(img);

                        var titleContainer = document.createElement('div');
                        titleContainer.classList.add('title-container');
                        workCard.appendChild(titleContainer);

                        var dateSpan = document.createElement('span');
                        dateSpan.classList.add('work-date');
                        dateSpan.textContent = work.date;
                        titleContainer.appendChild(dateSpan);

                        var titleSpan = document.createElement('span');
                        titleSpan.classList.add('work-title');
                        titleSpan.textContent = work.title;
                        titleContainer.appendChild(titleSpan);

                        if (work.status !== "") {
                            var etiquetteContainer = document.createElement('div');
                            etiquetteContainer.classList.add('etiquette-container');
                            if (work.status === 'Avant') {
                                etiquetteContainer.classList.add('etiquette-avant');
                            } else if (work.status === 'Après') {
                                etiquetteContainer.classList.add('etiquette-apres');
                            }

                            var etiquetteSpan = document.createElement('span');
                            etiquetteSpan.classList.add('etiquette');
                            etiquetteSpan.textContent = work.status;
                            etiquetteContainer.appendChild(etiquetteSpan);

                            workCard.appendChild(etiquetteContainer);
                        }

                        worksList.appendChild(workCard);
                    });
                });
        });
    });
});



/*FILTRAGE DES TRAVAUX AU CLIC SUR LA CATEGORIE*/
document.addEventListener('DOMContentLoaded', function() {
    // Ouverture de la modale
    const openModal = function(e) {
        e.preventDefault();
        const target = document.querySelector(e.target.getAttribute('href'));
        target.style.display = null;
        target.removeAttribute('aria-hidden');
        target.setAttribute('aria-modal', 'true');
        modal = target;
        modal.addEventListener('click', closeModal);
        modal.querySelector('#nav_modal1').addEventListener('click', closeModal);
        modal.querySelector('.js-modal-stop').addEventListener('click', stopPropagation);

        // Générer les projets dans la modale
        genererProjets().then(projets => afficherProjetsModal(projets));
    };

    document.querySelectorAll('.open_modal').forEach(a => {
        a.addEventListener('click', openModal);
    });

    const closeModal = function(e) {
        if (modal === null) return;
        e.preventDefault();
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        modal.removeAttribute('aria-modal');
        modal.removeEventListener('click', closeModal);
        modal.querySelector('#nav_modal1').removeEventListener('click', closeModal);
        modal.querySelector('.js-modal-stop').removeEventListener('click', stopPropagation);
        modal = null;
    };

    const stopPropagation = function(e) {
        e.stopPropagation();
    };

    // Générer les projets (Exemple de fetch)
    async function genererProjets() {
        const response = await fetch("/api/works"); // Remplacez par l'URL de votre API
        const projets = await response.json();
        return projets;
    }

    // Afficher les projets dans la modale
    function afficherProjetsModal(work) {
        let miniaturesProjet = document.querySelector(".miniatures_projets");
        miniaturesProjet.innerHTML = "";

        work.forEach((projet, i) => {
            let figureProjet = document.createElement("figure");
            figureProjet.className = "figure_miniature";

            let imageProjet = document.createElement("img");
            imageProjet.src = './uploads/images/' + projet.image;
            imageProjet.alt = projet.title;
            imageProjet.style.width = "75px";
            imageProjet.style.height = "100px";

            let divIconeCorbeille = document.createElement("div");
            divIconeCorbeille.className = "div_icone_corbeille";
            divIconeCorbeille.addEventListener('click', async function(e) {
                e.preventDefault();
                figureProjet.remove();
                await supprimerProjets(projet.id); // Suppression de l'image dans la base de données
            });

            let iconeCorbeille = document.createElement("i");
            iconeCorbeille.className = "fa-regular fa-trash-can icone_corbeille";


            miniaturesProjet.appendChild(figureProjet);
            figureProjet.appendChild(imageProjet);
            figureProjet.appendChild(divIconeCorbeille);
            divIconeCorbeille.appendChild(iconeCorbeille);


        });
    }

    // Fonction pour supprimer un projet (Exemple de fetch)
    async function supprimerProjets(workId) {
        await fetch(`/api/works/${workId}`, { method: 'DELETE' }); // Remplacez par l'URL de votre API
    }
});


