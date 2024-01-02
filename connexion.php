<?php
//Vérifie si la personne est déjà connecté
session_start();
if(isset($_SESSION['login']))
{
  $txtnohotel = $_REQUEST['txtnohotel'];
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
    <form method="post" action="php/choix.php">
        <h3>Connexion</h3>

        <!-- S'il y a une erreur, elle sera afficher en haut du formulaire -->
        <?php
        if (isset($_SESSION["erreur1"])):
            $errorMessage = $_SESSION["erreur1"];
            ?>
            <h1 class="erreur" style="color: red; font-size: 15px; text-align: center"><?php echo $errorMessage; ?></h1>
        <?php endif;?>
        <label for="username">Utilisateur</label>
        <input type="text" autocomplete="off" placeholder="Username" id="username" name="txtusername">

        <label for="password">Mot de passe</label>
        <input type="password" autocomplete="off" placeholder="Mot de passe" id="password" name="txtpassword">

        <label for="mail">E-Mail (pas besoin si connexion)</label>
        <input type="email" placeholder="Adresse mail" id="mail" name="txtmail">

        <input type="hidden" name="txtnohotel" value="<?php if(isset($_REQUEST['txtnohotel'])){echo $_REQUEST['txtnohotel'];} ?>"/>
        <input type="submit" name="action" id="btnvalider" value="Connecter"/>
        <input type="submit" name="action" id="btncreate" value="Création"/>
    </form>
</body>
</html>
