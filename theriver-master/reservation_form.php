<?php
session_start();
require_once('php/ouverture.php');
require_once('php/fermeture.php');

if(!isset($_SESSION['login']))
{
  header("Location: connexion.php");
  exit();
}
$txtnohotel = $_SESSION['nohotel'];
$cnn = connexionBDD();
$requete="select distinct nochambre from chambre order by nochambre";
$mesdonnees=$cnn->prepare($requete);
$mesdonnees->execute();
$leslignes = $mesdonnees->fetchall();
?>
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
  <script>var isConnected = <?php echo isset($_SESSION['login']) ? 'true' : 'false'; ?>;</script>
  <script src="js/main.js"></script>
</head>
<body>

<div class="super_container">

  <!-- Header -->

  <header class="header">
    <div class="header_content d-flex flex-row align-items-center justify-content-start">
      <div class="logo"><a href="index.php">Balladins</a></div>
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
      <div class="menu_book text-right"><a href="#">Réservation en ligne</a></div>
    </div>
  </div>
  <!-- Home -->

  <div class="home">
    <div class="background_image" style="background-image:url(images/booking.jpg)"></div>
    <div class="home_container">
      <div class="container">
        <div class="row">
          <div class="col">
            <div class="home_content text-center">
              <div class="home_title">Réserver une chambre</div>
              <div class="booking_form_container">
                <form action="php/reservation.php" class="booking_form" id="booking_form" method="post">
                  <div class="d-flex flex-xl-row flex-column align-items-start justify-content-start">
                    <div class="booking_input_container d-flex flex-row align-items-start justify-content-center flex-wrap">
                      <div><input type="text" class="datepicker booking_input booking_input_a booking_in" placeholder="Arriver" name="dateD" required="required"></div>
                      <div><input type="text" class="datepicker booking_input booking_input_a booking_out" placeholder="Départ" name="dateF" required="required"></div>
                      <div><select name="lstchambre[]" multiple class="booking_input booking_input_b" placeholder="Chambre" required="required">
                          <?php
                          foreach ($leslignes as $uneligne) {
                              echo "<option value=" . $uneligne['nochambre'] . ">" . $uneligne['nochambre'] . "</option>";
                          }
                          ?>
                        </select></div>
<!--                      <div><input type="number" class="booking_input booking_input_b" placeholder="Chambre" required="required"></div>-->
                      <input type="hidden" name="txtnohotel" value="<?php if($txtnohotel){echo $txtnohotel;} unset($_SESSION['txtnohotel'])?>"/>
                      <input type="hidden" name="txtdateD" value="<?php if(isset($_REQUEST['txtdateD'])){echo $_REQUEST['txtdateD'];} ?>"/>
                      <input type="hidden" name="txtdateF" value="<?php if(isset($_REQUEST['txtdateF'])){echo $_REQUEST['txtdateF'];} ?>"/>
                    </div>
                    <button class="booking_button trans_200" type="submit">Reserver maintenant</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
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
              <input type="email" class="newsletter_input" placeholder="Votre adresse e-mail" required="required">
              <button class="newsletter_button">S'abonner</button>
            </form>
          </div>
        </div>

        <!-- Footer images -->
        <div class="col-lg-3">
          <div class="certificates d-flex flex-row align-items-start justify-content-lg-between justify-content-start flex-lg-nowrap flex-wrap">
            <div class="cert"><img src="images/cert_1.png" alt=""></div>
            <div class="cert"><img src="images/cert_2.png" alt=""></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="copyright">
    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</a>
  </div>
</footer>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="styles/bootstrap-4.1.2/popper.js"></script>
<script src="styles/bootstrap-4.1.2/bootstrap.min.js"></script>
<script src="plugins/greensock/TweenMax.min.js"></script>
<script src="plugins/greensock/TimelineMax.min.js"></script>
<script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="plugins/greensock/animation.gsap.min.js"></script>
<script src="plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="plugins/OwlCarousel2-2.3.4/owl.carousel.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="plugins/progressbar/progressbar.min.js"></script>
<script src="plugins/parallax-js-master/parallax.min.js"></script>
<script src="plugins/jquery-datepicker/jquery-ui.js"></script>
<script src="plugins/colorbox/jquery.colorbox-min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
