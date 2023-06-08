<?php
require_once 'data/define.php';
// Connection au serveur
try {
    $dns = 'mysql:host=localhost;dbname=stages';
    $utilisateur = 'root';
    $motDePasse = '';
    $connection = new PDO($dns, $utilisateur, $motDePasse);
    $connection->query("SET NAMES utf8");
} catch (Exception $e) {
    echo "Connection Ã  MySQL impossible : ", $e->getMessage();
    die();
}
?>