<?php
    require ("choix.php");
    require("ouverture.php");
    ?>
<?php

//Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['login']))
{
    header("Location: reservation.php");
    exit();
}
if($_SERVER["REQUEST_METHOD"]=="post")
{

}
$reqresult ="SELECT nomClient, mdpClient FROM client where nomClient=? and mdpClient=?";

$mesdonnees=$cnn->prepare($reqresult);
$mesdonnees->bindParam(1,$login, PDO::PARAM_STR);
$mesdonnees->bindParam(2,$mdp, PDO::PARAM_STR);
try
{
    $mesdonnees->execute();
}
catch(PDOException $e)
{
    die('<span>Erreur : </span>' . $e->getMessage());
}

// lecture de la 1ère ligne
$unequ = $mesdonnees->fetch();
    if ($unequ && password_verify($mdp, $unequ["mdpClient"])) {
        $_SESSION["login"] = $login;
        $cost = 12;
        // Création du jeton (token) unique pour l'utilisateur connecté
        // Hashage du token
        $_SESSION['token'] = password_hash(time() * rand(50, 250), PASSWORD_BCRYPT, ['cost' => $cost]);
        unset($_SESSION["erreur"]);
        header("Location: reservation.php");  // Redirection automatique vers la page backoffice.php, si l'identification est correcte
    } else {
        $_SESSION["erreur"] = "Il faut saisir un login & un mot de passe correct !!!".$unequ;
        header("Location: ../connexion.php"); // Redirection automatique vers la page form.php, si l'identification est incorrecte

}
$mesdonnees->closeCursor();
// Vérification login & mdp


/*echo("<br/>A. Nombre d'équipements : ? <br/>");
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
// Fermetures

$reqresult->closeCursor();*/
?>
