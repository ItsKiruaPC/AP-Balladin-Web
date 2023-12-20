<?php
session_start();
require_once('php/ouverture.php');
require_once('php/fermeture.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>About us</title>
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
<link rel="stylesheet" type="text/css" href="styles/about.css">
<link rel="stylesheet" type="text/css" href="styles/about_responsive.css">
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
            <li class="active"><a href="about.php">À propos de nous</a></li>
            <li><a href="booking.php">Chambres</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php
            // Vérifie si l'utilisateur est connecté
            if (isset($_SESSION['login'])) {
              // Affiche le bouton de déconnexion
              echo '<div class="book_button"  onclick="afficher()">
          <div class="header-user_wrap">
            <div class="header-user" style="background-image: url(photo/01.jpg);" ></div>
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
							<div class="home_title">A propos de nous</div>
							<div class="booking_form_container">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- About -->

	<div class="about">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="about_title"><h2>Balladins / Des années d'expériences</h2></div>
				</div>
			</div>
			<div class="row about_row">

				<!-- About Content -->
				<div class="col-lg-6">
					<div class="about_content">
						<div class="about_text">
              <p>Riche d'une forte notoriété dans le paysage hôtelier français, l'enseigne balladins et ses nuances se positionnent principalement sur des établissements classés 2 et 3 étoiles. <br><br>Le réseau balladins, avec plus de 35 ans d'expérience au service de ses clients, a su capitaliser sur son expertise d'une chaîne hôtelière à taille humaine. balladins est aujourd'hui une enseigne incontournable du marché de l'hôtellerie économique en France et a été élue "3ème meilleure chaïne d'Hôtellerie française" selon une étude réalisée par l’Institut STATISTA parue dans le numéro de Novembre 2016 du magazine Capital.</p>
						</div>
						<div class="about_sig"><img src="images/sig.png" alt=""></div>
					</div>
				</div>

				<!-- About Images -->
				<div class="col-lg-6">
					<div class="about_images d-flex flex-row align-items-start justify-content-between flex-wrap">
						<img src="images/about_1.png" alt="">
						<img src="images/about_2.png" alt="">
						<img src="images/about_3.png" alt="">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Split Section Right -->

	<div class="split_section_right container_custom">
		<div class="container">
			<div class="row row-xl-eq-height">

				<div class="col-xl-6 order-xl-1 order-2">
					<div class="split_section_image">
						<div class="background_image" style="background-image:url(images/milestones.jpg)"></div>
					</div>
				</div>

				<div class="col-xl-6 order-xl-2 order-1">
					<div class="split_section_right_content">
						<div class="split_section_title"><h1>Complexe de luxe</h1></div>
						<div class="split_section_text">
              <p>Niché au cœur d'un paysage enchanteur, le complexe de luxe des Balladins incarne l'élégance et le raffinement dans un cadre naturel exceptionnel. Entouré par des jardins luxuriants et des vues panoramiques, cet établissement prestigieux offre une escapade exquise pour ceux en quête d'une expérience inoubliable. Dès l'arrivée, les hôtes sont accueillis par un service attentionné et personnalisé. Les jardins parfaitement entretenus invitent à la détente, offrant des sentiers sinueux et des recoins paisibles pour se relaxer. Le bâtiment principal, une merveille architecturale, mêle habilement le charme traditionnel à des touches contemporaines. Les chambres et suites somptueusement décorées sont des havres de confort, dotées d'équipements modernes et offrant des vues imprenables sur les environs. Chaque détail a été soigneusement pensé pour assurer un séjour d'exception, alliant luxe et sérénité.</p>
						</div>

						<!-- Milestones -->
						<div class="milestones_container d-flex flex-row align-items-start justify-content-start flex-wrap">

							<!-- Milestone -->
							<div class="milestone d-flex flex-row align-items-start justify-content-start">
								<div class="milestone_content">
									<div class="milestone_counter" data-end-value="45">0</div>
									<div class="milestone_title">Rooms available</div>
								</div>
							</div>

							<!-- Milestone -->
							<div class="milestone d-flex flex-row align-items-start justify-content-start">
								<div class="milestone_content">
									<div class="milestone_counter" data-end-value="21" data-sign-after="K">0</div>
									<div class="milestone_title">Tourists this year</div>
								</div>
							</div>

							<!-- Milestone -->
							<div class="milestone d-flex flex-row align-items-start justify-content-start">
								<div class="milestone_content">
									<div class="milestone_counter" data-end-value="2">0</div>
									<div class="milestone_title">Swimming pools</div>
								</div>
							</div>

						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- Split Section Left -->

	<div class="split_section_left container_custom">
		<div class="container">
			<div class="row">
				<div class="col-xl-6">
					<div class="split_section_left_content">
						<div class="split_section_title"><h1>Salle de mariage</h1></div>
						<div class="split_section_text">
							<p>La salle de mariage au sein du complexe de luxe Balladins incarne l'élégance et le charme, offrant un cadre idyllique pour célébrer l'amour et l'union de deux âmes. Nichée au cœur d'un environnement pittoresque, cette salle de réception marie subtilement le raffinement à une ambiance chaleureuse et accueillante. Spacieuse et lumineuse, la salle est aménagée avec un souci du détail exquis. Des éléments décoratifs soigneusement sélectionnés ajoutent une touche de sophistication à l'espace, tandis que la disposition flexible permet d'adapter la configuration selon les préférences des mariés pour ce jour si spécial. Les grandes fenêtres laissent entrer la lumière naturelle, offrant une vue imprenable sur les jardins luxuriants ou les panoramas environnants, créant ainsi une toile de fond magique pour la célébration. Un mariage en plein air peut également être organisé dans les jardins bien entretenus, offrant une ambiance romantique et intime.</p>
						</div>

						<!-- Loaders -->
						<div class="loaders_container d-flex flex-row align-items-start justify-content-start flex-wrap">

							<!-- Loader -->
							<div class="loader_container text-center">
								<div class="loader text-center" data-perc="0.9">
									<div class="loader_content">
										<div class="loader_title">Good Services</div>
									</div>
								</div>
							</div>

							<!-- Loader -->
							<div class="loader_container text-center">
								<div class="loader text-center" data-perc="0.8">
									<div class="loader_content">
										<div class="loader_title">Tourists</div>
									</div>
								</div>
							</div>

							<!-- Loader -->
							<div class="loader_container text-center">
								<div class="loader text-center" data-perc="1.0">
									<div class="loader_content">
										<div class="loader_title">Satisfaction</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

				<!-- Loaders Image -->
				<div class="col-xl-6">
					<div class="split_section_image split_section_left_image">
						<div class="background_image" style="background-image:url(images/loaders.jpg)"></div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- Testimonials -->

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
</div>
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
<script src="js/about.js"></script>
</body>
</html>
