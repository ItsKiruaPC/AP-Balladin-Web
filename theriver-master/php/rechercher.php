<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Balladins</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Le projet de Balladins">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../styles/bootstrap-4.1.2/bootstrap.min.css">
    <link href="../plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.3.4/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.3.4/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="../plugins/OwlCarousel2-2.3.4/animate.css">
    <link href="../plugins/jquery-datepicker/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="../plugins/colorbox/colorbox.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../styles/booking.css">
    <link rel="stylesheet" type="text/css" href="../styles/booking_responsive.css">
</head>
<?php
session_start();
require_once ('ouverture.php');
require_once ('fermeture.php');

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $ville=$_REQUEST['txtville'];
    $nom=$_REQUEST['txtnom'];
    $prix=$_REQUEST['txtprix'];
    $ville=htmlspecialchars($ville, ENT_QUOTES);
    $nom=htmlspecialchars($nom,ENT_QUOTES);
    $prix=htmlspecialchars($prix, ENT_QUOTES);
    $cnn = connexionBDD();
    $requete="select * from hotel";
if ($ville!="")
{
  $requete=$requete . " where ville like '%$ville%'";
  if ($nom!="")
  {
    $requete=$requete . " and nom like '%$nom%'";
    if ($prix!="")
    {
      $requete=$requete . " and prix<= $prix order by prix desc";
    }
  }
  else if ($prix!="")
  {
    $requete=$requete . " and prix<= $prix order by prix desc";
  }
}

elseif ($nom != "")
{
  $requete=$requete . " where nom like '%$nom%'";
  if ($prix!="")
  {
    $requete=$requete . " and prix <=$prix order by prix desc";
  }
}
elseif ($prix!="")
{
    $requete=$requete . " where prix <=$prix order by prix desc";
}
else
{
  $requete=$requete . " order by ville";
}
    $mesdonnees=$cnn->prepare($requete);
    $mesdonnees->bindParam(1,$ville,PDO::PARAM_STR);
    $mesdonnees->bindParam(2,$nom,PDO::PARAM_STR);
    $mesdonnees->bindParam(3,$prix,PDO::PARAM_STR);
    try
    {
        $mesdonnees->execute();
    }
    catch (Exception $e)
    {
      die('<span> Erreur : </span>'.$e->getMessage());
    }
    $leslignes = $mesdonnees->fetchall();
    //Boucle qui se repette tant qu'il reste des données à afficher
    ?>
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
    <?php
    foreach ($leslignes as $uneligne)
    {
      ?>
      <div class="booking_item">
        <div class="background_image" style="background-image:url(../images/booking_1.jpg)"></div>
        <div class="booking_overlay trans_200"></div>
        <div class="booking_item_content">
          <div class="booking_item_list">
            <ul><?php
                $nohotel=$uneligne['nohotel'];
                echo "<li>Adresse principal : ".$uneligne['adr1']."</li>";
                echo "<li>Adresse secondaire : ".$uneligne['adr2'].'</li>';
                echo "<li>Code Postal : ".$uneligne['cp'].'</li>';
                echo "<li>Ville : ".$uneligne['ville'].'</li>';
                echo "<li>Téléphone : ".$uneligne['tel'].'</li>';
                echo "<li>Description : ".$uneligne['descourt'].'</li>';
            ?></ul>
          </div>
        </div>
      <div class="booking_price"><?php echo intval($uneligne['prix'])?>€/nuit</div>
        <form method="post" action="../booking.php">
          <button class="booking_link" type="submit" name="nohotel" value="<?php echo $nohotel ?>"><?php echo $uneligne['nom']?></button>
        </form>
      </div>
    <?php
    }?>
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
                            <div class="cert"><img src="../images/cert_1.png" alt=""></div>
                            <div class="cert"><img src="../images/cert_2.png" alt=""></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</a>
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
$mesdonnees->closeCursor();
closeBDD($cnn);
}
?>

