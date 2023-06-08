<?php
    include '../inc.connexion.php';
    $sqlajout = "INSERT INTO sta_promotion(libelle_promotion) VALUES ('".$_REQUEST['libelle_promotion']."')";
    $connection->exec($sqlajout);
    header('Location: ../gestionPromotions.php');
