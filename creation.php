<?php
//Vérifie si la personne est déjà connecté
session_start();
if(isset($_SESSION['login']))
{
  $txtnohotel = $_REQUEST['txtnohotel'];
  $txtnohotel = htmlspecialchars($txtnohotel, ENT_QUOTES);
  $_SESSION['nohotel'] = $txtnohotel;
  header("Location: reservation_form.php");
}
?>

<!-- Ajout du css, de script et de plugins -->
<!DOCTYPE html>
<html lang="fr" >
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion - Veuillez vous connecter</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles/connexion.css">
</head>
<body>
<div class="background">
  <div class="shape"></div>
  <div class="shape"></div>
</div>

<!-- Récupère les données écrites et les renvoie a une page qui détecte soit la connection ou la création -->
<form method="post" action="php/creation.php">
  <h3>Connexion</h3>

  <!-- S'il y a une erreur, elle sera afficher en haut du formulaire -->
  <?php
  if (isset($_SESSION["erreur1"])):
    $errorMessage = $_SESSION["erreur1"];
    ?>
    <h1 class="erreur" style="color: red; font-size: 15px; text-align: center"><?php echo $errorMessage; ?></h1>
  <?php endif;?>
  <label for="username">Utilisateur</label>
  <input type="text" autocomplete="off" placeholder="Username" id="username" name="txtusername" required pattern="[A-Za-z0-9]{}" oninvalid="setCustomValidity('Veuillez ne pas utiliser de caractères spéciaux. \nUtiliser seulement de [a-z/A-Z/0-9]')">

  <label for="password">Mot de passe</label>
  <input type="password" autocomplete="off" placeholder="Mot de passe" id="password" name="txtpassword" required>

  <label for="mail">E-Mail (pas besoin si connexion)</label>
  <input type="mail" placeholder="Adresse mail" id="mail" name="txtmail" pattern="[A-Za-z0-9]{}" oninvalid="setCustomValidity('Veuillez ne pas utiliser de caractères spéciaux. \nUtiliser seulement de [a-z/A-Z/0-9]')">

  <input type="hidden" name="txtnohotel" value="<?php if(isset($_REQUEST['txtnohotel'])){echo $_REQUEST['txtnohotel'];} ?>"/>
  <input type="submit" name="action" id="btncreate" value="Création"/>
  <a href="connexion.php"><input type="button" value="Connexion"/></a>
</form>
</body>
</html>
