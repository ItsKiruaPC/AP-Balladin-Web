<?php
session_start();
require_once('../administration/ouverture.php');
require_once('fermeture.php');
//Pour éviter d'atteindre la page si les données ne sont pas renseignées
if(!isset($_SESSION['login'])||!isset($_REQUEST['txtnohotel'])||!isset($_REQUEST['txtdateD'])||!isset($_REQUEST['txtdateF']))
{
    header("Location: ../connexion.php");
}
$nbPersonne = $_REQUEST['nbPersonne'];
$nomClient = $_SESSION['login'];
$nohotel = $_REQUEST['txtnohotel'];
$dateD = $_REQUEST['txtdateD'];
$dateF = $_REQUEST['txtdateF'];
$chambres = array_map('intval', explode(',', trim($_REQUEST["listchambres"])));

$nohotel = intval($nohotel); // Assurez-vous que $nohotel est un entier
$dateD = htmlspecialchars($dateD, ENT_QUOTES);
$dateF = htmlspecialchars($dateF, ENT_QUOTES);

$nomClient = htmlspecialchars($nomClient, ENT_QUOTES);
$dateD = date('Y-m-d', strtotime($dateD));
$dateF = date('Y-m-d', strtotime($dateF));

for ($i = 0; $i < 4; $i++) {
  $code = mt_rand(0, 9);
}

for ($i = 0; $i < 4; $i++) {
  $code .= mt_rand(0, 9);
}
$code = (float)$code;

$cnn = connexionBDD();
if ($nohotel==0)
{
  $_SESSION['erreur'] = "Veuillez choisir un hotel";
  header("Location: ../index.php");
  exit();
}
$requete= $cnn->prepare("select * from client where nomClient= ?");
$requete ->execute(array($nomClient));
$leslignes = $requete->fetch(PDO::FETCH_ASSOC);

if ($leslignes) {
  $mail = $leslignes['email'];
  $noClient = $leslignes['noClient'];
  $chambreDisponible = true;

  //Si elle est disponible alors ...
  $requete0 = $cnn->prepare("select max(nores) from reservation");
  $requete0->execute();
  $donnee = $requete0->fetchColumn();
  $donnee++;
  if($dateD>=date("Y-m-d") && $dateF>$dateD)
  {
    $requete1 = $cnn->prepare("INSERT INTO reservation VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $requete1->execute(array($donnee, $nohotel, $dateD, $dateF, $nomClient, $mail, $code, $noClient));

    foreach ($chambres as $unechambre) {
      $requete2 = $cnn->prepare("INSERT INTO reserv VALUES (?, ?, ?)");
      $requete2->execute(array($donnee, $nohotel, $unechambre));
    }
      for($i = 0; $i<$nbPersonne; $i++) {
          $nomP = $_REQUEST['prenom'.$i];
          $nomN = $_REQUEST['nom'.$i];
          $requete3 = $cnn->prepare("INSERT INTO personne(nom,prenom,idReservation) VALUES (?, ?, ?)");
          $requete3->execute(array($nomN, $nomP, $donnee));
      }
  }
  else
  {
      echo $dateD;
    $_SESSION['erreur'] = "La date est soit trop ancienne comparer à aujourd'hui ou la date de fin s'arrete avant le début";
  }
}
?>
<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html">
<head>
  <title>Booking</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="The River template project">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="../styles/bootstrap-4.1.2/bootstrap.min.css">
  <link href="../plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.3.4/owl.carousel.css">
  <link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.3.4/owl.theme.default.css">
  <link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.3.4/animate.css">
  <link href="../plugins/jquery-datepicker/jquery-ui.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="../styles/booking.css">
  <link rel="stylesheet" type="text/css" href="../styles/booking_responsive.css">
</head>
<body>
<div class="super_container">
  <div class="super_container">

    <!-- Header -->

    <header class="header">
      <div class="header_content d-flex flex-row align-items-center justify-content-start">
        <div class="logo"><a href="../index.php">Balladins</a></div>
        <div class="ml-auto d-flex flex-row align-items-center justify-content-start">
          <nav class="main_nav">
            <ul class="d-flex flex-row align-items-start justify-content-start">
              <li><a href="../index.php">Accueil</a></li>
              <li><a href="../about.php">À propos de nous</a></li>
              <li><a href="../booking.php">Chambres</a></li>
              <li><a href="../contact.php">Contact</a></li>
              <?php
              // Vérifie si l'utilisateur est connecté
              if (isset($_SESSION['login'])) {
                // Affiche le bouton de déconnexion
                echo '<div class="book_button"  onclick="afficher()">
          <div class="header-user_wrap">
            <div class="header-user" style="background-image: url(../images/user-circle-regular-24.png); height: 30px; width: 35px;" ></div>
            <svg class="header-user_arrow" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
              <path fill="currentColor" d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z" data-darkreader-inline-fill="" style="--darkreader-inline-fill: currentColor;"></path>
            </svg>
          </div>
          <div class="header-user_menu" id="test">
            <ul class="compte">
              <li><a href="../mesreservation.php">Mes réservations</a></li>
              <li><a href="" id="logOut">Deconnexion</a></li>
              </ul>
          </div>
        </div>';
              } else {
                // Affiche le bouton de connexion
                echo '<li><a href="../connexion.php" id="logIn">Connexion</a></li>';
              }
              ?>
            </ul>
          </nav>


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
            <li><a href="../index.php">Accueil</a></li>
            <li><a href="../about.php">À propos de nous</a></li>
            <li><a href="../booking.php">Chambres</a></li>
            <li><a href="../contact.php">Contact</a></li>
            <?php
            // Vérifie si l'utilisateur est connecté
            if (isset($_SESSION['login'])) {
              echo '<li><a href="../mesreservation.php">Mes réservations</a></li>';
              // Affiche le bouton de déconnexion
              echo '<li><a href="" id="logOut">Déconnexion</a></li>';
            } else {
              // Affiche le bouton de connexion
              echo '<li><a href="../connexion.php" id="logIn">Connexion</a></li>';
            }
            ?>
          </ul>
        </nav>
      </div>
    </div>
  </div>
  <!-- Home -->

  <div class="home">
    <div class="background_image" style="background-image:url(../images/booking.jpg)"></div>
    <div class="home_container">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="home_content text-center">
              <div class="home_title">Réserver une chambre</div>
              <div class="booking_form_container">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="booking">
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="booking_item">
          <ul>
            <?php
            //Si la chambre est disponible et que sa date de fin est plug grande que celle du début
            if ($chambreDisponible)
            {
              if ($dateD >= date("Y-m-d") && $dateF > $dateD)
              {
                echo "<h1 style='display: flex; justify-content: center'>Réservation effectuer</h1>";
                echo "<h1 style='display: flex; justify-content: center'>Numéro de réservation: " . $donnee . "</h1>";
                echo "<h1 style='display: flex; justify-content: center'>Code d'accée: " . $code . "</h1>";
                echo "<h1 style='display: flex; justify-content: center'>Vous allez être redirigé à la page d'accueil</h1>";
                echo '<script>
                            setTimeout(function() {
                                window.location.href = "../index.php";
                            }, 3000);
                            </script>';
              }
              else
                echo "<h1>$_SESSION[erreur]</h1>";
              unset($_SESSION['erreur']);
            }
            else
              echo "<h1>$_SESSION[erreur]</h1>";
            unset($_SESSION['erreur']);?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Footer -->

<footer class="footer">
  <div class="footer_content">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="footer_logo_container text-center">
            <div class="footer_logo">
              <a href="#"></a>
              <div>Balladins</div>
              <div>depuis 1985</div>
            </div>
          </div>
        </div>
      </div>
      <div class="row footer_row">

        <!-- Address -->
        <div class="col-lg-3">
          <div class="footer_title">Notre adresse</div>
          <div class="footer_list">
            <ul>
              <li>Boulogne-Billancourt</li>
              <li>FRANCE</li>
            </ul>
          </div>
        </div>

        <!-- Reservations -->
        <div class="col-lg-3">
          <div class="footer_title">Reservations</div>
          <div class="footer_list">
            <ul>
              <li>Tél: 01 55 85 93 62</li>
              <li>reservations@balladins.com</li>
            </ul>
          </div>
        </div>

        <!-- Newsletter -->
        <div class="col-lg-3">
          <div class="footer_title">Newsletter</div>
          <div class="newsletter_container">
            <form action="#" class="newsletter_form" id="newsletter_form">
              <label>
                <input type="email" class="newsletter_input" placeholder="Votre adresse e-mail" required="required">
              </label>
              <button class="newsletter_button">S'abonner</button>
            </form>
          </div>
        </div>

        <!-- Footer images -->
        <div class="col-lg-3">
          <div class="certificates d-flex flex-row align-items-start justify-content-lg-between justify-content-start flex-lg-nowrap flex-wrap">
            <div class="cert"><img src="../images/cert_1.png" alt=""></div>
            <div class="cert"><img src="../images/cert_2.png" alt=""></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="copyright">
    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
  </div>
</footer>
<script src="../js/main.js"></script>
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../styles/bootstrap-4.1.2/popper.js"></script>
<script src="../styles/bootstrap-4.1.2/bootstrap.min.js"></script>
<script src="../plugins/greensock/TweenMax.min.js"></script>
<script src="../plugins/greensock/TimelineMax.min.js"></script>
<script src="../plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="../plugins/greensock/animation.gsap.min.js"></script>
<script src="../plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="../plugins/OwlCarousel2-2.3.4/owl.carousel.js"></script>
<script src="../plugins/easing/easing.js"></script>
<script src="../plugins/progressbar/progressbar.min.js"></script>
<script src="../plugins/parallax-js-master/parallax.min.js"></script>
<script src="../plugins/jquery-datepicker/jquery-ui.js"></script>
<script src="../plugins/colorbox/jquery.colorbox-min.js"></script>
<script src="../js/custom.js"></script>
</body>
</html>
<?php
closeBDD($cnn);
?>
