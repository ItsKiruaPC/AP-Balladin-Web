<?php

/*echo("Drivers sgbd installés pour pdo");

var_dump(PDO::getAvailableDrivers());*/
function connexionBDD()
{
    try {
        $cnn = new PDO("sqlsrv:Server=MSI\SQLEXPRESS;Database=bdciehotel", null, null);
        $cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connexion réussie à la base de données SQL Server.";
        return $cnn;

    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}
?>
