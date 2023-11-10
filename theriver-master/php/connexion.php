<?php
    session_start();
    require("ouverture.php");
    require("fermeture.php");

$login = $_REQUEST['username'];
$mdp = $_REQUEST['password'];
$login = filter_input(INPUT_REQUEST, 'username', FILTER_SANITIZE_STRING);
$mdp = filter_input(INPUT_REQUEST, 'password', FILTER_SANITIZE_STRING);
$reqresult ="SELECT * FROM client where nomClient=? and mdpClient=?";

$mesdonnees=$cnn->prepare($reqresult);
$mesdonnees->bindParam(1,$login, PDO::PARAM_STR);
$mesdonnees->bindParam(2,$mdp, PDO::PARAM_STR);
//Solution A. Récupérer les données ligne par ligne avec un while
try
{
    $mesdonnees->execute();
} catch(PDOException $e)
{
    die('<span>Erreur : </span>' . $e->getMessage());
}

// lecture de la 1ère ligne
$uneligne = $mesdonnees->fetch();

// Vérification login & mdp
if($uneligne && password_verify($mdp,$uneligne["mdpClient"]))
{
    $_SESSION["login"]=$login;
    $cost = 12;
// Création du jeton (token) unique pour l'utilisateur connecté
// Hashage du token
    $_SESSION['token'] = password_hash(time()*rand(50,250), PASSWORD_BCRYPT, ['cost' => $cost]);

    header("Location:../booking.html");  // Redirection automatique vers la page backoffice.php, si l'identification est correcte
}
else
{
    $_SESSION["erreur"]="Il faut saisir un login & un mot de passe correct !!!";
    header("Location:../connexion.html"); // Redirection automatique vers la page form.php, si l'identification est incorrecte
}
?>

/* echo("<br/>A. Nombre d'équipements : ? <br/>");
$unequ = $reqresult->fetch();
while ($unequ)
{
    echo ($unequ["noequ"] . " " . $unequ["lib"] . "<br/>");
    $unequ = $reqresult->fetch();
}

//Solution C. Récupérer toutes les données dans un tableau affiché avec un Foreach
$reqresult->execute();
$lesequ = $reqresult->fetchAll();
echo("<br/>C. Nombre d'équipements : " . count($lesequ) . "<br/>");
Foreach ($lesequ as $unequ)
{
    echo ($unequ["noequ"] . " " . $unequ["lib"] . "<br/>");
}
*/
// Fermetures

$reqresult->closeCursor();
