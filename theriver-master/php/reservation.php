<?php
session_start();
require_once('ouverture.php');
require_once('fermeture.php');

$nomClient = $_SESSION['login'];
$nohotel = $_REQUEST['txtnohotel'];
$dateD = $_REQUEST['dateD'];
$dateF = $_REQUEST['dateF'];
$chambre = $_REQUEST['lstchambre'];
// Échappement des variables pour éviter les injections SQL
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

function connexionBDD()
{

}

$cnn = connexionBDD();
$requete= $cnn->prepare("select * from client where nomClient= :nomClient");
$requete ->execute(array(':nomClient' => $nomClient));
$leslignes = $requete->fetch(PDO::FETCH_ASSOC);
if ($leslignes) {
  $mail = $leslignes['email'];
  $noClient = $leslignes['noClient'];
  $chambreDisponible = true; // Indicateur pour vérifier la disponibilité de la chambre

// Vérifier si la chambre est déjà réservée pour les dates spécifiées
  foreach ($chambre as $unechambre) {
    $requeteCheckChambre = $cnn->prepare("SELECT COUNT(*) FROM reservation r INNER JOIN reserv c ON r.nores = c.nores WHERE r.datefin >= ? AND r.datedeb <= ? AND c.nochambre = ? and c.nohotel= ?");
    $requeteCheckChambre->execute(array($dateD, $dateF, $unechambre, $nohotel));
    $resultat = $requeteCheckChambre->fetchColumn();

    if ($resultat > 0) {
      $chambreDisponible = false; // La chambre est déjà réservée
      break; // Sortir de la boucle dès qu'une chambre est trouvée déjà réservée
    }
  }
  if ($chambreDisponible) {
    $requete0 = $cnn->prepare("select max(nores) from reservation");
    $requete0->execute();
    $donnee = $requete0->fetchColumn();
    $donnee++;
    $requete1 = $cnn->prepare("INSERT INTO reservation VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $requete1->execute(array($donnee, $nohotel, $dateD, $dateF, $nomClient, $mail, $code, $noClient));

    foreach ($chambre as $unechambre) {
      $requete2 = $cnn->prepare("INSERT INTO reserv VALUES (?, ?, ?)");
      $requete2->execute(array($donnee, $nohotel, $unechambre));
    }
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
                <li class="active"><a href="../index.php">Accueil</a></li>
                <li><a href="../about.php">À propos de nous</a></li>
                <li><a href="../booking.php">Chambres</a></li>
                <li><a href="../contact.php">Contact</a></li>
                <li><a href="../connexion.php" id="logOut">Déconnexion</a></li>
              </ul>
            </nav>
            <div class="book_button"><a href="../booking.php">Réservation en ligne</a></div>

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
              <li><a href="../connexion.php" id="logOut">Déconnexion</a></li>;
            </ul>
          </nav>
        </div>
        <div class="menu_extra">
          <div class="menu_book text-right"><a href="#">Réservation en ligne</a></div>
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
                  if ($chambreDisponible) {
                  echo "<h1>Réservation effectuer</h1>";
                  echo "<h1>Numéro de réservation: ".$donnee."</h1>";
                  echo "<h1>Code d'accée: ".$code."</h1>";
                  }
                  else
                  {
                    echo "<h1>La chambre est déjà réservée pour les dates spécifiées.</h1>";
                  }?>
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
