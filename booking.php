<?php
//Connection avec la BDD
session_start();
require_once('php/ouverture.php');
require_once('php/fermeture.php');
$txtnohotel = $_REQUEST['nohotel'];

$cnn = connexionBDD();
$requete = "select prix from hotel where nohotel= ?";
$mesdonnees=$cnn->prepare($requete);
$mesdonnees->bindParam(1,$txtnohotel,PDO::PARAM_INT);
$mesdonnees->execute();
$laligne = $mesdonnees->fetchColumn();
?>
<!-- Ajout du css, de script et de plugins -->
<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html">
<head>
  <title>Booking</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="The River template project">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="styles/bootstrap-4.1.2/bootstrap.min.css">
  <link href="plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.3.4/owl.carousel.css">
  <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.3.4/owl.theme.default.css">
  <link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.3.4/animate.css">
  <link href="plugins/jquery-datepicker/jquery-ui.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="styles/booking.css">
  <link rel="stylesheet" type="text/css" href="styles/booking_responsive.css">
  <script>
    var isConnected = <?php echo isset($_SESSION['login']) ? 'true' : 'false'; ?>;
  </script>
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
            <li><a href="index.php">Accueil</a></li>
            <li><a href="about.php">À propos de nous</a></li>
            <li class="active"><a href="booking.php">Chambres</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php
            // Vérifie si l'utilisateur est connecté
            if (isset($_SESSION['login'])) {
              // Affiche le bouton de déconnexion
              echo '<div class="book_button"  onclick="afficher()">
          <div class="header-user_wrap">
            <div class="header-user" style="background-image: url(images/user-circle-regular-24.png); height: 30px; width: 35px;" ></div>
            <svg class="header-user_arrow" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
              <path fill="currentColor" d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z" data-darkreader-inline-fill="" style="--darkreader-inline-fill: currentColor;"></path>
            </svg>
          </div>
          <div class="header-user_menu" id="test">
            <ul class="compte">
              <li><a href="mesreservation.php">Mes réservations</a></li>
              <li><a href="" id="logOut">Deconnexion</a></li>
              </ul>
          </div>
        </div>';
            } else {
              // Affiche le bouton de connexion
              echo '<li><a href="connexion.php" id="logIn">Connexion</a></li>';
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
          <li><a href="index.php">Accueil</a></li>
          <li><a href="about.php">À propos de nous</a></li>
          <li><a href="booking.php">Chambres</a></li>
          <li><a href="contact.php">Contact</a></li>
          <?php
          // Vérifie si l'utilisateur est connecté
          if (isset($_SESSION['login'])) {
            echo '<li><a href="mesreservation.php">Mes réservations</a></li>';
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
            <div class="home_title">Types de chambres</div>
            <div class="booking_form_container">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Type de réservation -->

<div class="booking">
  <div class="container">
    <div class="row">
      <div class="col">

        <!-- Booking Slider -->
        <div class="booking_slider_container">
          <div class="owl-carousel owl-theme booking_slider">

            <!-- Slide -->
            <div class="booking_item">
              <div class="background_image" style="background-image:url(images/booking_1.jpg)"></div>
              <div class="booking_overlay trans_200"></div>
              <div class="booking_item_content">
                <div class="booking_item_list">
                  <ul>
                    <li>Terrasse de 27 m²</li>
                    <li>Balcon avec vue</li>
                    <li>Vue jardin/montagne</li>
                    <li>TV à écran plat</li>
                    <li>Climatisation</li>
                    <li>Insonorisation</li>
                    <li>Salle de bains privée</li>
                    <li>Wifi gratuit</li>
                  </ul>
                </div>
              </div>
              <?php if(!empty($txtnohotel)){ ?><div class="booking_price">80€/nuit</div><?php };?>
              <div class="booking_link"><a href="#famille">Chambre familliale</a></div>
            </div>

            <!-- Slide -->
            <div class="booking_item">
              <div class="background_image" style="background-image:url(images/booking_2.jpg)"></div>
              <div class="booking_overlay trans_200"></div>
              <div class="booking_item_content">
                <div class="booking_item_list">
                  <ul>
                    <li>Terrasse de 27 m²</li>
                    <li>Balcon avec vue</li>
                    <li>Vue jardin/montagne</li>
                    <li>TV à écran plat</li>
                    <li>Climatisation</li>
                    <li>Insonorisation</li>
                    <li>Salle de bains privée</li>
                    <li>Wifi gratuit</li>
                  </ul>
                </div>
              </div>
              <?php if(!empty($txtnohotel)){ ?><div class="booking_price">120€/nuit</div><?php };?>
              <div class="booking_link"><a href="#luxe">Chambre luxe</a></div>
            </div>

            <!-- Slide -->
            <div class="booking_item">
              <div class="background_image" style="background-image:url(images/booking_3.jpg)"></div>
              <div class="booking_overlay trans_200"></div>
              <div class="booking_item_content">
                <div class="booking_item_list">
                  <ul>
                    <li>Terrasse de 27 m²</li>
                    <li>Balcon avec vue</li>
                    <li>Vue jardin/montagne</li>
                    <li>TV à écran plat</li>
                    <li>Climatisation</li>
                    <li>Insonorisation</li>
                    <li>Salle de bains privée</li>
                    <li>Wifi gratuit</li>
                  </ul>
                </div>
              </div>
              <?php if(!empty($txtnohotel)){ ?><div class="booking_price"><?php echo $laligne."€/nuit";?></div><?php };?>
              <div class="booking_link"><a href="#double">Chambre double</a></div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Plus de détails sur les chambres -->

<div class="details">
  <div class="container">
    <div class="row">

      <!-- Details Image -->
      <div class="col-xl-7 col-lg-6">
        <div class="details_image">
          <div class="background_image" style="background-image:url(images/details_1.jpg)"></div>
        </div>
      </div>

      <!-- Details Content -->
      <div class="col-xl-5 col-lg-6">
        <div class="details_content">
          <div class="details_title" id="luxe">Chambre de luxe</div>
          <div class="details_list">
            <ul>
              <li>Terrasse de 27 m²</li>
              <li>Balcon avec vue</li>
              <li>Vue jardin/montagne</li>
              <li>TV à écran plat</li>
              <li>Climatisation</li>
              <li>Insonorisation</li>
              <li>Salle de bains privée</li>
              <li>Wifi gratuit</li>
            </ul>
          </div>
          <div class="details_long_list">
            <ul class="d-flex flex-row align-items-start justify-content-start flex-wrap">
              <li>Balcon</li>
              <li>Vue sur la montagne</li>
              <li>Terrasse</li>
              <li>Télévision</li>
              <li>Chaînes satellite</li>
              <li>Coffre-fort</li>
              <li>Chauffage</li>
              <li>Canapé</li>
              <li>Sol carrelé/marbre</li>
              <li>Moustiquaire</li>
              <li>Armoire/Placard</li>
              <li>Canapé-lit</li>
              <li>Douche</li>
              <li>Sèche-cheveux</li>
              <li>Articles de toilette gratuits</li>
              <li>Toilettes</li>
              <li>Bain ou douche</li>
              <li>Papier toilette</li>
              <li>Machine à thé/café</li>
              <li>Minibar</li>
              <li>Coin repas</li>
              <li>Bouilloire électrique</li>
              <li>Table à manger</li>
              <li>Mobilier d'extérieur</li>
              <li>Coin repas extérieur</li>
              <li>Serviettes</li>
              <li>Lin</li>
              <li>Étages supérieurs accessibles par ascenseur</li>
            </ul>
          </div>
          <form method="post" action="connexion.php">
            <input type="hidden" name="txtnohotel" value="<?php if(isset($_REQUEST['nohotel'])){echo $_REQUEST['nohotel'];} else {$_SESSION['erreur']="Merci de choisir un hotel avant";} ?>"/>

            <button class="book_now_button" name="txtsend" type="submit"> Reserver maintenant</button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Details Left -->

<div class="details">
  <div class="container">
    <div class="row">

      <!-- Details Content -->
      <div class="col-xl-5 col-lg-6 order-lg-1 order-2">
        <div class="details_content">
          <div class="details_title" id="double">Chambre double</div>
          <div class="details_list">
            <ul>
              <li>Terrasse de 27 m²</li>
              <li>Balcon avec vue</li>
              <li>Vue Jardin/Montagne</li>
              <li>Télévision à écran plat</li>
              <li>Climatisation</li>
              <li>Insonorisation</li>
              <li>Salle de bain privée</li>
              <li>Wi-Fi gratuit</li>
            </ul>
          </div>
          <div class="details_long_list">
            <ul class="d-flex flex-row align-items-start justify-content-start flex-wrap">
              <li>Balcon</li>
              <li>Vue sur la montagne</li>
              <li>Terrasse</li>
              <li>Télévision</li>
              <li>Chaînes satellite</li>
              <li>Coffre-fort</li>
              <li>Chauffage</li>
              <li>Canapé</li>
              <li>Sol carrelé/marbre</li>
              <li>Moustiquaire</li>
              <li>Armoire/Placard</li>
              <li>Canapé-lit</li>
              <li>Douche</li>
              <li>Sèche-cheveux</li>
              <li>Articles de toilette gratuits</li>
              <li>Toilettes</li>
              <li>Bain ou douche</li>
              <li>Papier toilette</li>
              <li>Machine à thé/café</li>
              <li>Minibar</li>
              <li>Coin repas</li>
              <li>Bouilloire électrique</li>
              <li>Table à manger</li>
              <li>Mobilier d'extérieur</li>
              <li>Coin repas extérieur</li>
              <li>Serviettes</li>
              <li>Lin</li>
              <li>Étages supérieurs accessibles par ascenseur</li>
            </ul>
          </div>
          <form method="post" action="connexion.php">
            <input type="hidden" name="txtnohotel" value="<?php if(isset($_REQUEST['nohotel'])){echo $_REQUEST['nohotel'];} else {$_SESSION['erreur']="Merci de choisir un hotel avant";} ?>"/>
            <button class="book_now_button" name="txtsend" type="submit"> Reserver maintenant</button>
          </form>
        </div>
      </div>

      <!-- Details Image -->
      <div class="col-xl-7 col-lg-6 order-lg-2 order-1">
        <div class="details_image">
          <div class="background_image" style="background-image:url(images/details_2.jpg)"></div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Special -->

<div class="special">
  <div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="images/special.jpg" data-speed="0.8"></div>
  <div class="container">
    <div class="row">
      <!-- Details Image -->
      <div class="col-xl-7 col-lg-6 order-lg-2 order-1">
        <div class="details_image">
          <div class="background_image" style="background-image:url(images/gallery_3.jpg)"></div>
        </div>
      </div>
      <div class="col-xl-5 col-lg-6">
        <div class="special_content">
          <div class="details_title" id="famille">Offre Spéciale - Chambre Familiale</div>
          <div class="details_list">
            <ul>
              <li>Terrasse de 27 m²</li>
              <li>Balcon avec vue</li>
              <li>Vue Jardin/Montagne</li>
              <li>Télévision à écran plat</li>
              <li>Climatisation</li>
              <li>Insonorisation</li>
              <li>Salle de bain privée</li>
              <li>Wi-Fi gratuit</li>
            </ul>
          </div>
          <div class="details_long_list">
            <ul class="d-flex flex-row align-items-start justify-content-start flex-wrap">
              <li>Balcon</li>
              <li>Vue sur la montagne</li>
              <li>Terrasse</li>
              <li>Télévision</li>
              <li>Chaînes satellite</li>
              <li>Coffre-fort</li>
              <li>Chauffage</li>
              <li>Canapé</li>
              <li>Sol carrelé/marbre</li>
              <li>Moustiquaire</li>
              <li>Armoire/Placard</li>
              <li>Canapé-lit</li>
              <li>Douche</li>
              <li>Sèche-cheveux</li>
              <li>Articles de toilette gratuits</li>
              <li>Toilettes</li>
              <li>Bain ou douche</li>
              <li>Papier toilette</li>
              <li>Machine à thé/café</li>
              <li>Minibar</li>
              <li>Coin repas</li>
              <li>Bouilloire électrique</li>
              <li>Table à manger</li>
              <li>Mobilier d'extérieur</li>
              <li>Coin repas extérieur</li>
              <li>Serviettes</li>
              <li>Lin</li>
              <li>Étages supérieurs accessibles par ascenseur</li>
            </ul>
          </div>
          <form method="post" action="connexion.php">
            <input type="hidden" name="txtnohotel" value="<?php if(isset($_REQUEST['nohotel'])){echo $_REQUEST['nohotel'];} else {$_SESSION['erreur']="Merci de choisir un hotel avant";} ?>"/>
            <button class="book_now_button" name="txtsend" type="submit"> Reserver maintenant</button>
          </form>
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
    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  </div>
</footer>
<script src="js/main.js"></script>
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
<script src="js/booking.js"></script>
</body>
</html>
