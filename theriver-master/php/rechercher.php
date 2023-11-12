<?php
session_start();
require 'ouverture.php';
require 'fermeture.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['btnRechercher']=="Rechercher")
{
$ville=$_REQUEST['txtville'];
$nom=$_REQUEST['txtnom'];
$prix=$_REQUEST['txtprix'];
$ville=htmlspecialchars($ville);
$nom=htmlspecialchars($nom);
$prix=htmlspecialchars($prix);
$requete="select * as 'Prix' from hotel where ville like=? or nom like=? or prix<=?";
$uneRequete=$cnn->prepare($requete);
$uneRequete->bindParam(1,$ville,PDO::PARAM_STR);
$uneRequete->bindParam(2,$ville,PDO::PARAM_STR);
$uneRequete->bindParam(3,$ville,PDO::PARAM_INT);
try
{
    $uneRequete->execute();
}
catch (Exception $e)
{
  die('<span> Erreur : </span>'.$e->getMessage());
}
$leslignes = $uneRequete->fetchall();
//Boucle qui se repette tant qu'il reste des données à afficher
?>
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

            echo $uneligne['adr1'];
            echo $uneligne['adr2'];
            echo $uneligne['cp'];
            echo $uneligne['ville'];
            echo $uneligne['tel'];
            echo $uneligne['descourt'];
        ?></ul>
      </div>
    </div>
  <div class="booking_price"><?php echo $uneligne['prix']?>€/nuit</div>
  <div class="booking_link"><?php echo $uneligne['nom']?></div>
  </div>
<?php
}?>
</div>
    </div>
  </div>
  <?php
$uneRequete->closeCursor();
}
?>

