<?php
//Appel de page connexion et déconnexion et vérification s'il y a eu une erreur
session_start();
require_once('administration/ouverture.php');
require_once('php/fermeture.php');

$nbPersonne = $_REQUEST['personneF'];
$txtnohotel = $_SESSION['nohotel'];
$txtnohotel = htmlspecialchars($txtnohotel, ENT_QUOTES);
$chambres = array_map('intval', explode(',', trim($_POST["listchambres"])));
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
            <form class="booking_form" id="booking-form1" method="post" action="php/reservation.php">
                  <div class="d-flex flex-xl-row flex-column align-items-left justify-content-center">
                    <div style="background:rgba(0,0,0,0.7);">
                        <div class="booking_input_container d-flex flex-row align-items-start justify-content-center flex-wrap">
                        <?php
                        if (!isset($_REQUEST['btnAccept']))
                        {
                        ?>
                            <?php
                            for($i=0; $i< $nbPersonne; $i++)
                            {
                                ?>
                                    <input type="text" placeholder="Nom" name="nom<?php echo $i ?>" required>
                                    <input type="text" placeholder="prénom" name="prenom<?php echo $i ?>" required>
                                <?php
                            }
                        }
                        if (!isset($_REQUEST['btnAccept']))
                        {
                        ?>
                          </div>
                          </div>
                          <div><button style="margin-top:30px;" class="booking_button trans_200" type="submit" name="btnAccept">Valider</button></div>
                        <?php
                        }
                        ?>
                  </div>
                <input type="hidden" name="txtnohotel" value="<?php if($txtnohotel!=""){echo $txtnohotel;} unset($_SESSION['txtnohotel'])?>" readonly/>
                <input type="hidden" name="txtdateD" value="<?php if(isset($_REQUEST['txtdateD'])){echo $_REQUEST['txtdateD'];} ?>"/>
                <input type="hidden" name="txtdateF" value="<?php if(isset($_REQUEST['txtdateF'])){echo $_REQUEST['txtdateF'];} ?>"/>
                <input type="hidden" name="listchambres" value="<?php if(isset($_REQUEST['listchambres'])){echo $_REQUEST['listchambres'];} ?>"/>
                <input type="hidden" name="nbPersonne" value="<?php if(isset($_REQUEST['nbPersonne'])){echo $_REQUEST['nbPersonne'];} ?>"/>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>