<?php
    include '../inc.connexion.php';

    $sqlajout = "INSERT INTO sta_periode(date_debut, date_fin, idclasse) VALUES ('".$_REQUEST['debutPeriode']."', '".$_REQUEST['finPeriode']."', '".$_REQUEST['promoPeriode']."')";
    $connection->exec($sqlajout);

?>