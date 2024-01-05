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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action']=="Création")
{
  $errors = array();

  if (empty($login)) {
    $errors[] = "Le nom d'utilisateur est requis.";
  }

  if (empty($mdp)) {
    $errors[] = "Le mot de passe est requis.";
  }
  if(empty($mail))
  {
    $errors[] = "Le mail est requis.";
  }
//Vérifie si la variable possède des erreurs
  if (empty($errors))
  {
    $cnn = connexionBDD();


    $reqresult = "SELECT COUNT(*) FROM client where nomClient=?";
    $mesdonnees = $cnn->prepare($reqresult);
    $mesdonnees->execute([$login]);
    $count = $mesdonnees->fetchColumn();

    if ($count > 0) {
      $_SESSION['erreur1'] = "Le nom d'utilisateur existe déjà.";
      header("Location: ../connexion.php");
      exit();
    }
    //Insérer le compte client
    $reqresult = "INSERT INTO client (nomClient, mdpClient, email) VALUES (?, ?, ?)";
    $mesdonnees = $cnn->prepare($reqresult);
    //Hachage mot de passe
    $hashedPassword = password_hash($mdp, PASSWORD_BCRYPT);
    try
    {
      $mesdonnees->execute([$login, $hashedPassword, $mail]);
      if ($mesdonnees->rowCount() > 0)
      {
        $_SESSION['erreur1']="Compte créé avec succès!";
        header("Location: ../connexion.php");
        exit();
      }
    }
    catch (PDOException $e)
    {
      echo "Erreur d'insertion : ".$e->getMessage();
    }
  }
  else
  {
    $_SESSION['erreur1'] = "Erreur lors de la création du compte.";
    header("Location: ../connexion.php");
    exit();
  }
  $mesdonnees = null;
  closeBDD($cnn);
}
//Connection d'un compte
elseif ($_POST['action'] == 'Connecter')
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
