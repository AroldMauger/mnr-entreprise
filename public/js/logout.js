// DECONNEXION
document.getElementById('lienLogout').addEventListener('click', function(event) {
    event.preventDefault();
    if (confirm("Êtes-vous sûr de vouloir vous déconnecter?")) {
        window.location.href = "/logout";
    }
});
