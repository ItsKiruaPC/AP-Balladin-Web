<?php
function closeBDD()
{
    $cnn=null;
}
function deconnexion()
{
  session_start();
  session_unset(); // Efface toutes les variables de session
  session_destroy(); // Détruit la session

// Redirige vers la page de connexion (ou une autre page après la déconnexion)
  header("Location: ../connexion.php");
  exit();
}
?>
