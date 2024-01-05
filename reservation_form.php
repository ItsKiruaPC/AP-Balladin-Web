<?php
//Appel de page connexion et déconnexion et vérification s'il y a eu une erreur
session_start();
require_once('administration/ouverture.php');
require_once('php/fermeture.php');
$txtnohotel = $_SESSION['nohotel'];
$txtnohotel = htmlspecialchars($txtnohotel, ENT_QUOTES);
if(!isset($_SESSION['login']))
{
  header("Location: connexion.php");
  exit();
}
//Permet de récupérer le numéro de l'hôtel s'il existe sinon il redirige vers la page d'accueil
if($_SESSION['nohotel'] != "")
{

  $cnn = connexionBDD();
  $requete = "select nochambre from chambre where nohotel= ? order by nochambre";
  $mesdonnees = $cnn->prepare($requete);
  $mesdonnees->bindParam(1,$txtnohotel,PDO::PARAM_INT);
  $mesdonnees->execute();
  $leslignes = $mesdonnees->fetchall();
}
else
{
  header('Location: index.php');
}
//Permet de voir les chambres disponibles pour les dates choisi
if (isset($_REQUEST['btnAccept']))
{
  $datedeb = $_REQUEST['dateD'];
  $datefin = $_REQUEST['dateF'];
$req = $cnn->prepare("SELECT nochambre FROM chambre WHERE nohotel=CONVERT(varchar,:n1) AND nochambre NOT IN ( SELECT nochambre FROM  reserv INNER JOIN reservation ON reserv.nores=reservation.nores WHERE reservation.nohotel=CONVERT(varchar,:n2) AND(    (datedeb>=CONVERT(varchar,:d1)
    AND datedeb<CONVERT(varchar,:d2)) OR (datefin>CONVERT(varchar,:d3) AND datefin<=CONVERT(varchar,:d4)) OR (datedeb<=CONVERT(varchar,:d5)
    AND datefin>=CONVERT(varchar,:d6))))");

  $req->bindParam(':n1',$txtnohotel, PDO::PARAM_INT);
  $req->bindParam(':n2',$txtnohotel, PDO::PARAM_INT);
  $req->bindParam(':d1',$datedeb, PDO::PARAM_STR);
  $req->bindParam(':d2',$datefin, PDO::PARAM_STR);
  $req->bindParam(':d3',$datedeb, PDO::PARAM_STR);
  $req->bindParam(':d4',$datefin, PDO::PARAM_STR);
  $req->bindParam(':d5',$datedeb, PDO::PARAM_STR);
  $req->bindParam(':d6',$datefin, PDO::PARAM_STR);
  $req->execute();
  $req1 = $req->fetchAll();

}
?>
<!-- Ajout du css, de script et de plugins -->
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
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <script>var isConnected = <?php echo isset($_SESSION['login']) ? 'true' : 'false'; ?>;</script>
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
            <li><a href="booking.php">Chambres</a></li>
            <li><a href="contact.php">Contact</a></li>
            <div class="book_button" onclick="afficher()">
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
            </div>
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
          <li><a href="mesreservation.php">Mes réservations</a></li>';
          <li><a href="" id="logOut">Déconnexion</a></li>';
        </ul>
      </nav>
    </div>
  </div>
</div>
<!-- Home -->

<div class="home">
  <div class="background_image" style="background-image:url(images/booking.jpg)"></div>
  <div class="home_container" style="top: 20%">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="home_content text-center">
            <div class="home_title">Réserver une chambre</div>
            <div class="booking_form_container">
              <form class="booking_form" method="post">
                <div class="d-flex flex-xl-row flex-column align-items-left justify-content-center">
                  <div class="booking_input_container d-flex flex-row align-items-start justify-content-center flex-wrap">
                    <?php
                    if (!isset($_REQUEST['btnAccept']))
                    {
                      ?>

                      <div><p style="color:black; font-weight:bold">Date d'arrivé</p><input type="date" autocomplete="off" class=" booking_input booking_input_a booking_in" id="datePickerMin" placeholder="Arriver" name="dateD" required></div>
                      <div><p style="color:black; font-weight:bold">Date de départ</p><input type="date" autocomplete="off" class=" booking_input booking_input_a booking_out" id="datePickerMax" placeholder="Départ" name="dateF" required></div>
                      <?php
                    }
                    if (!isset($_REQUEST['btnAccept']))
                    {
                      ?>
                      <div><button style="margin-top:30px" class="booking_button trans_200" type="submit" name="btnAccept">Valider</button></div>
                      <?php
                    }
                    ?>
                  </div>
                </div>
              </form>
              <?php
              if (isset($_REQUEST['btnAccept']))
              {
              ?>
              <form action="php/reservation.php" class="booking_form2" method="post">
                <link rel="stylesheet" href="styles/multi-select.css">
                <div id="multi-select">
                  <input type='hidden' id='inputSelectedItems' name="listchambres">
                  <label for="items-selected" style="display: none; color: white;">Chambre(s) selectionné(s)</label>
                  <div id="items-selected" data-items-selected></div>
                  <b><label for="items-available" style="display: none; color: white;">Chambre(s) disponible(s)</label></b>
                  <div id="items-available" data-items-available></div>
                </div>
                <div>
                  <!-- Partie de Tom sur la séléction des chambres (je n'avais pas d'idée de comment l'afficher autre que par une liste) -->
                  <script src="js/multi-select.js"></script>
                  <script>
                    <!-- button settings -->
                    titleAvailable = "Ajouter la chambre";
                    titleSelected = "Retirer la chambre";
                    innerHTMLLeftAvailable = "";
                    innerHTMLLeftSelected = "";
                    innerHTMLRightAvailable = "";
                    innerHTMLRightSelected = "";
                    idItem = "item";

                    listItemsUpdateStr = [<?php echo json_encode(implode(',', array_column($req1, 'nochambre'))) ?>];
                    listAllItemsStr = [<?php echo json_encode(implode(',', array_column($leslignes, 'nochambre'))) ?>];

                    // init
                    UpdateItems(listItemsUpdateStr, listAllItemsStr);
                  </script>
                  <!-- Fin de Tom -->
                </div>
                <input type="hidden" name="txtnohotel" value="<?php if($txtnohotel!=""){echo $txtnohotel;} unset($_SESSION['txtnohotel'])?>" readonly/>
                <input type="hidden" name="txtdateD" value="<?php if(isset($_REQUEST['dateD'])){echo $_REQUEST['dateD'];} ?>"/>
                <input type="hidden" name="txtdateF" value="<?php if(isset($_REQUEST['dateF'])){echo $_REQUEST['dateF'];} ?>"/>
            </div>
            <button class="booking_button trans_200" type="submit">Reserver maintenant</button>
            </form>
            <?php
            }
            ?>

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
    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
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
<script src="plugins/colorbox/jquery.colorbox-min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
