document.addEventListener("DOMContentLoaded", function() {
  // Récupère les éléments des boutons
  var logIn = document.getElementById("logIn");
  var logOut = document.getElementById("logOut");

  if (isConnected) {
    logOut.style.display = "block";
  } else {
    // Sinon, affiche le bouton de connexion
    logIn.style.display = "block";
  }

  if (logOut) {
    logOut.addEventListener("click", function() {
      // Envoie une requête au serveur pour déconnecter l'utilisateur
      fetch("../php/deconnexion.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Si la déconnexion réussit, redirige vers la page de connexion
            window.location.href = "../connexion.php";
          } else {
            // Gérez les erreurs si nécessaire
            console.error(data.message);
          }
        })
        .catch(error => {
          console.error("Erreur lors de la déconnexion:", error);
        });
    });
  }
  // Affiche le bouton de déconnexion si l'utilisateur est connecté
});
