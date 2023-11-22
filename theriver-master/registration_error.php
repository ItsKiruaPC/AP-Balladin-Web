<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Balladins</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Le projet de Balladins">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="styles/bootstrap-4.1.2/bootstrap.min.css">
  <link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.3.4/owl.carousel.css">
  <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.3.4/owl.theme.default.css">
  <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.3.4/animate.css">
  <link href="plugins/jquery-datepicker/jquery-ui.css" rel="stylesheet" type="text/css">
  <link href="plugins/colorbox/colorbox.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="styles/main_styles.css">
  <link rel="stylesheet" type="text/css" href="styles/responsive.css">
  <script>
    var isConnected = <?php echo isset($_SESSION['login']) ? 'true' : 'false'; ?>;
  </script>
</head>
<body>

<div class="super_container">

  <!-- Header -->

  <header class="header">
    <div class="header_content d-flex flex-row align-items-center justify-content-start">
      <div class="logo"><a href="#">Balladins</a></div>
      <div class="ml-auto d-flex flex-row align-items-center justify-content-start">
        <nav class="main_nav">
          <ul class="d-flex flex-row align-items-start justify-content-start">
            <li class="active"><a href="index.php">Accueil</a></li>
            <li><a href="about.php">À propos de nous</a></li>
            <li><a href="booking.php">Chambres</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php
            // Vérifie si l'utilisateur est connecté
            if (isset($_SESSION['login'])) {
              // Affiche le bouton de déconnexion
              echo '<li><a href="" id="logOut">Déconnexion</a></li>';
            } else {
              // Affiche le bouton de connexion
              echo '<li><a href="connexion.php" id="logIn">Connexion</a></li>';
            }
            ?>
          </ul>
        </nav>
        <div class="book_button"><a href="booking.php">Réservation en ligne</a></div>

        <!-- Hamburger Menu -->
        <div class="hamburger"><i class="fa fa-bars" aria-hidden="true"></i></div>
      </div>
    </div>
  </header>

  <!-- Menu -->

  <div class="menu trans_400 d-flex flex-column align-items-end justify-content-start">
    <div class="menu_close"><i class="fa fa-times" aria-hidden="true"></i></div>
    <div class="menu_content">
      <nav class="menu_nav text-right">
        <ul>
          <li><a href="index.php">Accueil</a></li>
          <li><a href="about.php">À propos de nous</a></li>
          <li><a href="booking.php">Chambres</a></li>
          <li><a href="contact.php">Contact</a></li>
          <?php
            // Vérifie si l'utilisateur est connecté
            if (isset($_SESSION['login'])) {
              // Affiche le bouton de déconnexion
              echo '<li><a href="" id="logOut">Déconnexion</a></li>';
            } else {
              // Affiche le bouton de connexion
              echo '<li><a href="connexion.php" id="logIn">Connexion</a></li>';
            }
            ?>
        </ul>
      </nav>
    </div>
    <div class="menu_extra">
      <div class="menu_book text-right"><a href="booking.php">Réservation en ligne</a></div>
    </div>
  </div>
</div>

<?php if (!empty($errors)): ?>
  <ul style="color: red;">
    <?php foreach ($errors as $error): ?>
      <li><?php echo $error; ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<form method="post" action="php/connexion.php">
  <h3>Connexion</h3>

  <label for="username">Username</label>
  <input type="text" placeholder="E-mail" id="username">

  <label for="password">Password</label>
  <input type="password" placeholder="Mot de passe" id="password">

  <input type="submit" id="btnvalider" value="Connecter"/>
  <input type="submit" id="btncreate" value="Création"/>
</form>
</body>
</html>
