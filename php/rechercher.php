<!-- Ajout du css, de script et de plugins -->
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
    //Permet de rechercher l'hôtel demandé par le prix et/ou la ville
    session_start();
    require_once ('../administration/ouverture.php');
    require_once ('fermeture.php');
    unset($_SESSION['erreur']);
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $ville=$_REQUEST['txtville'];
        $prix=$_REQUEST['txtprix'];
        $ville=htmlspecialchars($ville, ENT_QUOTES);
        $prix=htmlspecialchars($prix, ENT_QUOTES);
        $ville = '%'.$ville.'%';
        $cnn = connexionBDD();
        $requete="select * from hotel";

        if (!empty($_REQUEST['txtville']))
        {
          $requete=$requete . " where nom like ?";

          if ($prix!="")
          {
            $requete=$requete . " and prix < ? order by prix desc";
            $mesdonnees=$cnn->prepare($requete);
            $mesdonnees->bindParam(1,$ville,PDO::PARAM_STR);
            $mesdonnees->bindParam(2,$prix,PDO::PARAM_INT);
          }
          else
          {
            $requete = $requete . " order by nom";
            $mesdonnees=$cnn->prepare($requete);
            $mesdonnees->bindParam(1,$ville,PDO::PARAM_STR);
          }
        }
        else
        {
          $requete=$requete . " where prix <=? order by prix desc";
          $mesdonnees=$cnn->prepare($requete);
          $mesdonnees->bindParam(1,$prix,PDO::PARAM_INT);
        }
//      else if (!empty($_REQUEST['txtprix']))
//      {
//        $requete=$requete . " where prix <=? order by prix desc";
//        $mesdonnees=$cnn->prepare($requete);
//        $mesdonnees->bindParam(1,$prix,PDO::PARAM_INT);
//      }
//        else
//        {
//          $requete=$requete . " order by nom";
//          $mesdonnees=$cnn->prepare($requete);
//        }
    try
    {
      $mesdonnees->execute();
    }
    catch (Exception $e)
    {
      die('<span> Erreur : </span>'.$e->getMessage());
    }
    $leslignes = $mesdonnees->fetchall();

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
              <li><a href="../index.php">Accueil</a></li>
              <li><a href="../about.php">À propos de nous</a></li>
              <li><a href="../booking.php">Chambres</a></li>
              <li><a href="../contact.php">Contact</a></li>
              <?php
              // Vérifie si l'utilisateur est connecté
              if (isset($_SESSION['login']))
              {
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
              }
              else
              {
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
<div class="container">
  <div class="row">
    <div class="col">

      <!-- Affichage des hôtels -->
      <?php
      foreach ($leslignes as $uneligne)
      {?>
        <div class="booking_item">
          <?php
          //Récupère les photos de l'hôtel
          $requete1 = "select * from photo where nohotel=$uneligne[nohotel]";
          $mesdonnees1=$cnn->prepare($requete1);
          $mesdonnees1->execute();
          $lesphotos = $mesdonnees1->fetchall();

          //Récupère le nom et photo(s) des équipements de l'hôtel
          $requete0="select lib, logo from equiper inner join equipement on equiper.noequ=equipement.noequ where nohotel=$uneligne[nohotel]";
          $mesdonnees1=$cnn->prepare($requete0);
          $mesdonnees1->execute();
          $leslignes1 = $mesdonnees1->fetchall();

          foreach ($lesphotos as $unephoto)
          {?>
            <div class="background_image" style="background-image:url('../photo/<?php echo $unephoto['nomfichier']?>'")></div>
            <?php
          }?>

          <div class="booking_overlay trans_200"></div>
          <div class="booking_item_content">
            <div class="booking_item_list">
              <ul>
                <?php
                $nohotel=$uneligne['nohotel'];
                echo "<li><b>Adresse principal :</b> ".$uneligne['adr1']."</li>";
                echo "<li><b>Adresse secondaire :</b> ".$uneligne['adr2'].'</li>';
                echo "<li><b>Code Postal :</b> ".$uneligne['cp'].'</li>';
                echo "<li><b>Ville :</b> ".$uneligne['ville'].'</li>';
                echo "<li><b>Téléphone :</b> ".$uneligne['tel'].'</li><br>';
                echo "<li><b>Description :</b> ".$uneligne['descourt'].'</li>';
                echo "<br><div class='test1'>";

                foreach ($leslignes1 as $unelignes)
                {
                  echo "<li><img src='../logo/$unelignes[logo]' width='50' />$unelignes[lib]</li>";
                }
                ?>
              </ul>
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

