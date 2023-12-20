<?php /** @noinspection ALL */
session_start();
require_once('php/ouverture.php');
require_once('php/fermeture.php');

if(isset($_REQUEST["txtnores"])) {
    $txtnores = $_REQUEST['txtnores'];
    $cnn = connexionBDD();
    $requete = "select * from reservation inner join hotel on hotel.nohotel = reservation.nohotel inner join client on reservation.noClient=client.noClient where nores=?";
    $mesdonnees = $cnn->prepare($requete);
    $mesdonnees->bindParam(1, $txtnores, PDO::PARAM_STR);
    $mesdonnees->execute();
    $leslignes = $mesdonnees->fetch();

}
if(isset($_REQUEST['txtnores'])) {
    while ($leslignes) {

        $requete4 = "delete from reserv where nores='$leslignes[nores]'";
        $mesdonnees3 = $cnn->prepare($requete4);
        $requete5 = "delete from reservation where nores='$leslignes[nores]' and datedeb='$leslignes[datedeb]' and datefin='$leslignes[datefin]'";
        $mesdonnees4 = $cnn->prepare($requete5);

        echo "$requete4<br>";
        echo "$requete5<br>";
    }
}
else
{
    echo ("bug 1");
}
?>