document.addEventListener("DOMContentLoaded", function() {
// Vérifie si l'utilisateur est connecté
var isConnected = <?php echo isset($_SESSION['login']) ? 'true' : 'false'; ?>;

// Affiche le bouton si l'utilisateur est connecté
if (isConnected) {
  document.getElementById("logOut").style.display = "block";
  document.getElementById("logIn").style.display = "none";
}
}
document.getElementById("logOut").addEventListener("click", function() {
  // Redirige vers la page de déconnexion
  window.location.href = "../php/fermeture.php";
});
