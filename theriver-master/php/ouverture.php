<?php

echo("Drivers sgbd installés pour pdo");

var_dump(PDO::getAvailableDrivers());
$cnn = new PDO("odbc:Driver={SQL Server};Server=MSI\SQLEXPRESS;Database=bdciehotel;Uid=sa;Pwd=mdpsa;");
$cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
