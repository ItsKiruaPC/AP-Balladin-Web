<?php
    session_start();
    ?>
<?php
$login=$_REQUEST['txtusername'];
$mdp=$_REQUEST['txtpassword'];
//Vérifier si l'utilisateur est déjà connecté


require("ouverture.php");
$login = htmlspecialchars($login, ENT_QUOTES);
$mdp = htmlspecialchars($mdp, ENT_QUOTES);
$reqresult ="SELECT * FROM client where nomClient=:paramLogin and mdpClient=:paramMdp";

$mesdonnees=$cnn->prepare($reqresult);
$mesdonnees->bindParam('paramLogin',$login, PDO::PARAM_STR);
$mesdonnees->bindParam('paramMdp',$mdp, PDO::PARAM_STR);
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

  if ($unequ || password_verify($mdp, $unequ['mdpClient'])) {
    $_SESSION["login"] = $login;
    $cost = 12;
    // Création du jeton (token) unique pour l'utilisateur connecté
    // Hashage du token
    $_SESSION['token'] = password_hash(time() * rand(50, 250), PASSWORD_BCRYPT, ['cost' => $cost]);
    //unset($_SESSION["erreur"]);
    header("Location: ../booking.html");  // Redirection automatique vers la page backoffice.php, si l'identification est correcte
  } else {
    $_SESSION["erreur"] = "Il faut saisir un login & un mot de passe correct !!!";
    header("Location: ../connexion.php"); // Redirection automatique vers la page form.php, si l'identification est incorrecte
  }
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
