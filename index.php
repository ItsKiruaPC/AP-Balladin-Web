<?php
//Appel de page connexion et déconnexion et vérification s'il y a eu une erreur
session_start();
require_once('administration/ouverture.php');
require_once('php/fermeture.php');

if (isset($_SESSION['erreur'])) 
{
    echo '<script>
    setTimeout(function() {
        //window.location.href = window.location.href.split("?")[0];
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "unset_session.php", true);
        xhr.send();
    },3000); // Redirection après 3 secondes
    </script>';
}
$cnn = connexionBDD();
$requete = "select * from hotel order by ville";
$mesdonnees=$cnn->prepare($requete);
$mesdonnees->execute();
$leslignes = $mesdonnees->fetchall();
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
<script>var isConnected = <?php echo isset($_SESSION['login']) ? 'true' : 'false'; ?>;</script>
<script src="js/main.js"></script>
</head>
<body>
<div class="super_container">
    
<!-- Navbar responsive pc et téléphone -->
	<!-- Header -->
	<header class="header">
		<div class="header_content d-flex flex-row align-items-center justify-content-start">
			<div class="logo"><a href="">Balladins</a></div>
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
		</div>
	</header>

	<!-- Menu Phone -->

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
                      echo '<li><a href="mesreservation.php">Mes réservations</a></li>';
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
    <!-- Première partie pour envoyer le form avec les valeurs -->
	<div class="home">
		<div class="background_image" style="background-image:url(images/booking.jpg)"></div>
		<div class="home_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="home_content text-center">
							<div class="home_title">Bienvenue Chez Balladins !</div>
                              <?php
                              if (isset($_SESSION['erreur']))
                                echo "<h2 style='color: red'>$_SESSION[erreur]</h2>";
                              ?>
							<div class="booking_form_container">
								<form method="post" action="php/rechercher.php" class="booking_form" id="booking_form">
									<div class="d-flex flex-xl-row flex-column align-items-start justify-content-center">
                                    <div class="booking_input_container d-flex flex-row align-items-start justify-content-center flex-wrap">

										<!-- Permet d'avoir une liste déroulante des hôtels par ville -->
									<div>
										<input placeholder="Veuillez choisir votre hotel" autocomplete="off" list="liste" name="txtville" id="list" class='booking_input booking_input_b'>
										<datalist id="liste">
										<?php
											foreach($leslignes as $uneligne)
											{
												echo "<option name='txtville' id='tags' value=".$uneligne['ville']."></option>";
											}
										?>
										</datalist>
									</div>
                                    <div><input class="booking_input booking_input_b" type="number" autocomplete="off" step="0.01" name="txtprix" placeholder="Prix maximum"/></div>
                                    <div><input class="booking_button trans_200" type="submit" name="btnRechercher" value="Rechercher"/></div>
                                    </div>
                                  </div>
                                </form>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Features -->

	<div class="features">
		<div class="container">
			<div class="row">

				<!-- Icon Box -->
				<div class="col-lg-4 icon_box_col">
					<div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
						<div class="icon_box_icon"><img src="images/icon_1.svg" class="svg" alt="https://www.flaticon.com/authors/monkik"></div>
						<div class="icon_box_title"><h2>Complexe fabuleux</h2></div>
						<div class="icon_box_text">
							<p>Bienvenue dans un monde d'exception, où chaque détail raconte une histoire de luxe et d'élégance. Notre hôtel incroyable est bien plus qu'un simple lieu de séjour, c'est une expérience immersive où le raffinement rencontre l'innovation pour créer des souvenirs inoubliables.</p>
						</div>
					</div>
				</div>

				<!-- Icon Box -->
				<div class="col-lg-4 icon_box_col">
					<div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
						<div class="icon_box_icon"><img src="images/icon_2.svg" class="svg" alt="https://www.flaticon.com/authors/monkik"></div>
						<div class="icon_box_title"><h2>Piscine gigantesque !</h2></div>
						<div class="icon_box_text">
							<p>Les hôtels Balladins sont réputés pour offrir une expérience de séjour exceptionnelle, et l'un des éléments qui distingue cette chaîne est sans aucun doute l'attention particulière portée à leurs installations de piscine. Que vous voyagiez pour affaires ou pour le plaisir, plonger dans l'ambiance relaxante des piscines Balladins est une expérience inoubliable.</p>
						</div>
					</div>
				</div>

				<!-- Icon Box -->
				<div class="col-lg-4 icon_box_col">
					<div class="icon_box d-flex flex-column align-items-center justify-content-start text-center">
						<div class="icon_box_icon"><img src="images/icon_3.svg" class="svg" alt="https://www.flaticon.com/authors/monkik"></div>
						<div class="icon_box_title"><h2>Chambre luxueuse</h2></div>
						<div class="icon_box_text">
							<p>Les chambres fabuleuses chez Balladins sont bien plus qu'un simple lieu de repos – ce sont des havres de confort et de raffinement qui transforment chaque séjour en une expérience exceptionnelle. Ces espaces élégamment aménagés témoignent de l'engagement inébranlable de Balladins envers le bien-être de ses clients.</p>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- Gallery -->

	<div class="gallery">
		<div class="gallery_slider_container">
			<div class="owl-carousel owl-theme gallery_slider">

				<!-- Slide -->
				<div class="gallery_item">
					<div class="background_image" style="background-image:url(images/gallery_1.jpg)"></div>
					<a class="colorbox" href="images/gallery_1.jpg"></a>
				</div>

				<!-- Slide -->
				<div class="gallery_item">
					<div class="background_image" style="background-image:url(images/gallery_2.jpg)"></div>
					<a class="colorbox" href="images/gallery_2.jpg"></a>
				</div>

				<!-- Slide -->
				<div class="gallery_item">
					<div class="background_image" style="background-image:url(images/gallery_3.jpg)"></div>
					<a class="colorbox" href="images/gallery_3.jpg"></a>
				</div>

				<!-- Slide -->
				<div class="gallery_item">
					<div class="background_image" style="background-image:url(images/gallery_4.jpg)"></div>
					<a class="colorbox" href="images/gallery_4.jpg"></a>
				</div>

			</div>
		</div>
	</div>

	<!-- About -->

	<div class="about">
		<div class="container">
			<div class="row">

				<!-- About Content -->
				<div class="col-lg-6">
					<div class="about_content">
						<div class="about_title"><h2>Balladins / Des années d'expériences</h2></div>
						<div class="about_text">
							<p>Riche d'une forte notoriété dans le paysage hôtelier français, l'enseigne balladins et ses nuances se positionnent principalement sur des établissements classés 2 et 3 étoiles. <br><br>Le réseau balladins, avec plus de 35 ans d'expérience au service de ses clients, a su capitaliser sur son expertise d'une chaîne hôtelière à taille humaine. balladins est aujourd'hui une enseigne incontournable du marché de l'hôtellerie économique en France et a été élue "3ème meilleure chaïne d'Hôtellerie française" selon une étude réalisée par l’Institut STATISTA parue dans le numéro de Novembre 2016 du magazine Capital.</p>
						</div>
					</div>
				</div>

				<!-- About Images -->
				<div class="col-lg-6">
					<div class="about_images d-flex flex-row align-items-center justify-content-between flex-wrap">
						<img src="images/about_1.png" alt="">
						<img src="images/about_2.png" alt="">
						<img src="images/about_3.png" alt="">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Avis -->

	<div class="testimonials">
		<div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="images/testimonials.jpg" data-speed="0.8"></div>
		<div class="testimonials_overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="testimonials_slider_container">

						<!-- Testimonials Slider -->
						<div class="owl-carousel owl-theme test_slider">

							<!-- Slide -->
							<div  class="test_slider_item text-center">
								<div class="rating rating_5 d-flex flex-row align-items-start justify-content-center"><i></i><i></i><i></i><i></i><i></i></div>
								<div class="testimonial_title"><a href="#">Hotel Genial</a></div>
								<div class="testimonial_text">
									<p>J'y suis déjà venu et j'y vais pour le travail. C'est vraiment un très bon hôtel. L'accueil est toujours très agréable, le personnel est vraiment serviable et sympa. Les chambres sont grandes et confortables Le petit déjeuner est complet. Il a une piscine. Je vous le recommande fortement 73€ la chambre, c'est très correct.</p>
								</div>
								<div class="testimonial_image"><img src="images/user_1.jpg" alt=""></div>
								<div class="testimonial_author"><a href="#">Samantha Smith</a>, Greece</div>
							</div>

							<!-- Slide -->
							<div  class="test_slider_item text-center">
								<div class="rating rating_5 d-flex flex-row align-items-start justify-content-center"><i></i><i></i><i></i><i></i><i></i></div>
								<div class="testimonial_title"><a href="#">Super endroit</a></div>
								<div class="testimonial_text">
									<p>Équipe exceptionnelle Arrangeante, toujours dispo. Connaissance top de la région. Bonne cuisine Chambre spatieuse et isolée du bruit. Excellent petit déjeuner. Plats variés et quantité au programme. Longue soirées près de la piscine +++</p>
								</div>
								<div class="testimonial_image"><img src="images/user_2.jpg" alt=""></div>
								<div class="testimonial_author"><a href="#">Michael Doe</a>, Italy</div>
							</div>

							<!-- Slide -->
							<div  class="test_slider_item text-center">
								<div class="rating rating_5 d-flex flex-row align-items-start justify-content-center"><i></i><i></i><i></i><i></i><i></i></div>
								<div class="testimonial_title"><a href="#">On a adoré</a></div>
								<div class="testimonial_text">
									<p>Accueil de bonne qualité. Chambre spacieuse et bien équipée pour la salle de bain. Bon petit-déjeuner. Hôtel bien insonorisé. Vue agréable du côté village. Bon rapport qualité prix. Salles de restauration agreables</p>
								</div>
								<div class="testimonial_image"><img src="images/user_3.jpg" alt=""></div>
								<div class="testimonial_author"><a href="#">Luis Garcia</a>, Spain</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Reservations -->

	<div class="booking">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="booking_title text-center"><h2>Réserver la chambre qui vous correspond</h2></div>
					<div class="booking_text text-center">
						<p>Parcourez notre sélection de chambres, des options Standard au luxe de nos Suites, et laissez les images vous donner un avant-goût du confort qui vous attend. Que vous optiez pour des chambres élégantes, des suites spacieuses ou des hébergements adaptés aux familles, chaque coin de nos espaces a été pensé pour répondre à vos besoins. Explorez, choisissez, et réservez votre retraite parfaite avec Balladins. Votre séjour de rêve commence ici.</p>
					</div>

					<!-- Booking Slider -->
					<div class="booking_slider_container">
						<div class="owl-carousel owl-theme booking_slider">

							<!-- Slide -->
							<div class="booking_item">
								<div class="background_image" style="background-image:url(images/booking_1.jpg)"></div>
								<div class="booking_overlay trans_200"></div>
								<div class="booking_price">80€/nuit</div>
								<div class="booking_link"><a href="booking.php">La chambre familliale</a></div>
							</div>

							<!-- Slide -->
							<div class="booking_item">
								<div class="background_image" style="background-image:url(images/booking_2.jpg)"></div>
								<div class="booking_overlay trans_200"></div>
								<div class="booking_price">120€/nuit</div>
								<div class="booking_link"><a href="booking.php">Chambre de luxe</a></div>
							</div>

							<!-- Slide -->
							<div class="booking_item">
								<div class="background_image" style="background-image:url(images/booking_3.jpg)"></div>
								<div class="booking_overlay trans_200"></div>
								<div class="booking_price">60€/nuit</div>
								<div class="booking_link"><a href="booking.php">Chambre simple</a></div>
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
