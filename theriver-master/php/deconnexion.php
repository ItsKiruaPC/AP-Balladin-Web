<?php
session_start();
session_unset(); // Efface toutes les variables de session
session_destroy(); // Détruit la session
header("Location: ../index.php");
echo json_encode(['success' => true]);
?>
