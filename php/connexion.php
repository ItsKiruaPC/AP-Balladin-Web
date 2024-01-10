<?php
//Permet de choisir entre la connection et la création d'un compte
session_start();
require_once('../administration/ouverture.php');
require_once('fermeture.php');
$login = $_REQUEST['txtusername'];
$mdp = $_REQUEST['txtpassword'];
$mail = $_REQUEST['txtmail'];
$txtnohotel = $_REQUEST['txtnohotel'];
$login=htmlspecialchars($login,ENT_QUOTES);
$mail=htmlspecialchars($mail,ENT_QUOTES);

if ($_POST['action'] == 'Connecter')
{
  $cnn=connexionBDD();
  $reqresult ="SELECT nomClient, mdpClient FROM client where nomClient=?";

  $mesdonnees=$cnn->prepare($reqresult);
  $mesdonnees->bindParam(1,$login, PDO::PARAM_STR);
  try
  {
    $mesdonnees->execute();
  }
  catch(PDOException $e)
  {
    die('<span>Erreur : </span>' . $e->getMessage());
  }
  $result = $mesdonnees->fetch();
  if($result)
  {
    $motDePasseHache = $result['mdpClient'];
    //Vérification du mot de passe chiffré
    if (password_verify($mdp, $motDePasseHache))
    {
      // L'utilisateur est connecté
      $_SESSION['login'] = $login;
      $cost = 12;
      $_SESSION['token'] = password_hash(time() * rand(50, 250), PASSWORD_BCRYPT, ['cost' => $cost]);
      $_SESSION['nohotel'] = $txtnohotel;
      echo "Connexion réussie!";
      header("Location: ../reservation_form.php");
    }
    else
    {
      // Échec de la connexion
      $_SESSION['erreur1']="Nom d'utilisateur ou mot de passe incorrect.";
      header("Location: ../connexion.php");
      exit();
    }
  }
  else {
    // Échec de la connexion
    $_SESSION['erreur1']="Nom d'utilisateur ou mot de passe incorrect.";
    header("Location: ../connexion.php");
    exit();
  }

  // Fermeture du statement et de la connexion
  $mesdonnees = null;
  closeBDD($mesdonnees);
}