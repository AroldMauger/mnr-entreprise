
document.addEventListener('DOMContentLoaded', function() {
    const buttonSupprimerGalerie = document.getElementById('button_supprimer_galerie');

    buttonSupprimerGalerie.addEventListener('click', function(event) {
        event.preventDefault(); // Empêche le comportement par défaut du lien

        // Affiche la boîte de dialogue de confirmation
        const confirmation = confirm('Êtes-vous sûr de vouloir supprimer toute la galerie? Vos photos seront perdues.');

        if (confirmation) {
            // Si l'utilisateur confirme, envoie une requête DELETE pour supprimer tous les travaux
            fetch('/api/works', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (response.ok) {
                        // Rafraîchit la page ou affiche un message de succès
                        alert('La galerie a été supprimée avec succès.');
                        location.reload(); // Recharge la page pour refléter les changements
                    } else {
                        alert('Une erreur est survenue lors de la suppression de la galerie.');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la suppression de la galerie.');
                });
        }
    });
});