<?php
session_start();
?>
<?php

if (isset($_POST['action'])) {
  if ($_POST['action'] == 'Création') {
    header('Location: creation.php');
    exit();
  }
  elseif ($_POST['action'] == 'Connecter')
  {
    header('Location: connexion.php');
    exit();
  }
}
?>
