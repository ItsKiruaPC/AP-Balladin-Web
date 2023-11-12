<?php
session_start();

$cnn = new PDO("sqlsrv:Server=AURORA-B550\SQLEXPRESS;Database=bdciehotel", null, null);
$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
  $password = $_POST['password'];

  if (empty($username)) {
    $errors[] = "Le nom d'utilisateur est requis.";
  }

  if (empty($password)) {
    $errors[] = "Le mot de passe est requis.";
  }

  if (empty($errors)) {

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $insertQuery = "INSERT INTO client (nomClient, mdpClient) VALUES (?, ?)";
    $stmt = $cnn->prepare($insertQuery);

    try {
      $stmt->execute([$username, $hashedPassword]);
      header("Location: ../booking.html");
      exit();
    } catch (PDOException $e) {
      die("Error: " . $e->getMessage());
    }
  } else {
    header("Location: ../registration_error.php");
    exit();
  }
}
?>
