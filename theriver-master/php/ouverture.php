<?php

/*echo("Drivers sgbd installés pour pdo");

var_dump(PDO::getAvailableDrivers());*/
try
{
  $cnn = new PDO("sqlsrv:Server=MSI\SQLEXPRESS;Database=bdciehotel", null,null);
  $cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connexion réussie à la base de données SQL Server.";
}
catch (PDOException $e)
{
    die("Erreur de connexion : " . $e->getMessage());
}
?>
