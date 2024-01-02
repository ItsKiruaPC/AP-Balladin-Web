<?php
//Appel de page connexion et déconnexion et vérification s'il y a eu une erreur
session_start();
require_once('php/ouverture.php');
require_once('php/fermeture.php');
if(!isset($_SESSION['login']))
{
    header("Location: index.php");
}
//Requête SQL pour voir les réservations attitré à la personne
$client = $_SESSION['login'];
$cnn = connexionBDD();
$requete = "select * from reservation inner join hotel on hotel.nohotel = reservation.nohotel inner join client on reservation.noClient=client.noClient where client.nomClient='$client'";
$mesdonnees = $cnn->prepare($requete);
$mesdonnees->execute();
$leslignes = $mesdonnees->fetchall();
$i = 1;

//Requête SQL pour supprimer la réservation
if(isset($_REQUEST["btnAnnuler"]))
{
    $txtnores = $_REQUEST['txtnores'];
    $requete = "delete from reserv where nores=$txtnores";
    $mesdonnees = $cnn->prepare($requete);
    $mesdonnees->execute();
    $requete = "delete from reservation where nores=$txtnores";
    $mesdonnees = $cnn->prepare($requete);
    $mesdonnees->execute();
    header("Location: mesreservation.php");
}
?>

<!-- Ajout du css, de script et de plugins -->
<!DOCTYPE html>
<head lang="fr">
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
  <link rel="stylesheet" type="text/css" href="styles/booking.css">
  <link rel="stylesheet" type="text/css" href="styles/booking_responsive.css">
  <link rel="stylesheet" type="text/css" href="styles/splide.min.css">
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
            if (isset($_SESSION['login']))
            {
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
            }
            else
            {
              // Affiche le bouton de connexion
              echo '<li><a href="connexion.php" id="logIn">Connexion</a></li>';
            }
            ?>
            </ul>
          </nav>


          <!-- Hamburger Menu -->
          <div class="hamburger"><i class="fa fa-bars" aria-hidden="true"></i></div>
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
            if (isset($_SESSION['login']))
            {
              echo '<li><a href="mesreservation.php">Mes Réservations</a></li>';
              // Affiche le bouton de déconnexion
              echo '<li><a href="" id="logOut">Déconnexion</a></li>';
            }
            else
            {
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
                  <!-- Vérifie s'il y une/des réservation(s) -->
                <?php
                if ($leslignes!=null)
                {?>
                    <div class="home_title">Mes réservations</div>

                    <?php if(isset($_REQUEST['btnAnnuler']))
                    {
                        echo "<h1 color='white'>La commande a été supprimer</h1>";
                    }
                }
                else
                {?>
                    <div class="home_title">Il n'y a pas de réservation</div>
                <?php
                }?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<!-- Affichage des données sous forme de "card" pour chaque réservation attitré à la personne -->
  <div class="tout" style="justify-content: center" >
  <?php
      if (isset($leslignes))
      {
        foreach ($leslignes as $uneligne)
        {
            ?>
        <div class="card-container">
          <section id="first-slider-<?php echo $i ?>" class="splide">
            <div class="splide__track">
              <ul class="splide__list">
                <?php
                $requete1 = "select * from photo where nohotel='$uneligne[nohotel]'";
                $mesdonnees1=$cnn->prepare($requete1);
                $mesdonnees1->execute();
                $leslignes1 = $mesdonnees1->fetchall();
                $requete0="select lib, logo from equiper inner join equipement on equiper.noequ=equipement.noequ where nohotel='$uneligne[nohotel]'";
                $mesdonnees2=$cnn->prepare($requete0);
                $mesdonnees2->execute();
                $leslignes2 = $mesdonnees2->fetchall();
                $requete2="select * from reserv where nores='$uneligne[nores]'";
                $mesdonnees3=$cnn->prepare($requete2);
                $mesdonnees3->execute();
                $leslignes3 = $mesdonnees3->fetchall();

                foreach ($leslignes1 as $photo)
                {?>
                  <li class="splide__slide"><img style="height: 300px; width: 550px" src=<?php echo "photo/". $photo['nomfichier']?> alt="Image de l'hotel"></li>
                <?php } ?>
              </ul>
            </div>
          </section>
            <main class="main-content">
              <h1><?php echo $uneligne['nom'] ?></h1>
              <h3>Code d'accès: <?php echo intval($uneligne['codeacces'])?></h3>
                <?php
                //Reinitialise a chaque fois le string des chambres
                $chambresString="";
                foreach ($leslignes3 as $chambre)
                {
                    $chambresString.=$chambre['nochambre'].",";
                }
                echo "<h3>Chambre(s): ".substr($chambresString, 0, -1)."</h3>";
                foreach ($leslignes2 as $unequipement)
                {?>
                  <div class="flex-row">
                    <div class="coin-base">
                      <img alt="logo de l'équipement" class="medium-image" src=<?php echo "logo/".$unequipement['logo']?> />
                      <h2><?php echo $unequipement['lib']?></h2>
                    </div>
                  </div>
                <?php
                }?>
                <form method="post">
                    <br>
                    <div class="booking_input_container d-flex flex-row align-items-start justify-content-center flex-wrap">
                        <div><input class="booking_button trans_200" type="submit" name="btnAnnuler" value="Annuler la réservation"/></div>
                        <input type="hidden" name="txtnores" value="<?php echo $uneligne['nores']?>">
                    </div>
                </form>
            </main>
        </div>
            <!-- Permet de créer autant de "card" que de réservation -->
        <?php
          $i++;
        }
      }
  ?>
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

<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/js/splide.min.js"></script>
<!-- Permet de créer autant de "card" que de réservation -->
<?php
foreach ($leslignes as $uneligne)
{?>
  <script>
  var elms = document.getElementsByClassName( 'splide' );

  for ( var i = 0; i < elms.length; i++ ) {
  new Splide( elms[ i ] ).mount();
  }
  </script>
<?php
}
?>
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
<script src="plugins/colorbox/jquery.colorbox-min.js"></script>
<script src="js/custom.js"></script>
</body>