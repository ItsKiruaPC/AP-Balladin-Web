<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr" >
<head>
  <meta charset="UTF-8">
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

    <?php
    if (isset($_SESSION['login'])) {
      header("Location: php/reservation.php");
      exit();
    }
    if (isset($_SESSION["erreur"])):
      $errorMessage = $_SESSION["erreur"];
      unset($_SESSION["erreur"]);
      ?>
    <h1><?php echo $errorMessage; ?></h1>
    <?php endif; ?>
    <form method="POST" action="php/connexion.php">
        <h3>Connexion</h3>

        <label for="username">Username</label>
        <input type="text" placeholder="Username" id="username" name="txtusername">

        <label for="password">Password</label>
        <input type="password" placeholder="Mot de passe" id="password" name="txtpassword">

        <input type="submit" name="action" id="btnvalider" value="Connecter"/>
        <input type="submit" name="action" id="btncreate" value="Création"/>
    </form>
</body>
</html>
