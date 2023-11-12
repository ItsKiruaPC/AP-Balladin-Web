<?php
session_start();
session_unset(); // Efface toutes les variables de session
session_destroy(); // Détruit la session

echo json_encode(['success' => true]);
?>
