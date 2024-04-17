<?php
/*echo("Drivers sgbd installés pour pdo");
var_dump(PDO::getAvailableDrivers());*/

//Connection à la BDD
function connexionBDD()
{
    try
    {
        $cnn = new PDO("sqlsrv:Server=MSI\SQLEXPRESS;Database=bdciehotel", null, null);
        $cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //en commentaire pour éviter de donner des infos aux hackeur
        //echo "Connexion réussie à la base de données SQL Server.";
        return $cnn;

    }
    catch (PDOException $e)
    {
        die("Erreur de connexion : " . $e->getMessage());
    }
}
