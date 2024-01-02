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
      fetch("php/deconnexion.php", {
        method: "post",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            console.log("Déconnexion réussie, redirection en cours...");
            window.location.href = "../index.php";
            // Si la déconnexion réussit, redirige vers la page de connexion
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
});
function afficher()
{
  var id = document.getElementById("test");
    var button = document.getElementById("button");
    if(id.style.display=="block")
    {
      id.style.display="none";
    }
    else
    {
      id.style.display="block";
    }
}
datePickerMin.min = new Date().toLocaleDateString("fr-ca")
datePickerMin.addEventListener('change', function() {
  document.getElementById("datePickerMax").setAttribute('min', this.value);
});