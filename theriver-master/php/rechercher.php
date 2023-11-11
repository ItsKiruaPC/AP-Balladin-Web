<?php
session_start();
require 'ouverture.php';
require 'fermeture.php';

$ville=$_REQUEST['txtville'];
$ville=htmlspecialchars($ville);
$requete="select * from ";
$uneRequete=$cnn->exec($requete);
