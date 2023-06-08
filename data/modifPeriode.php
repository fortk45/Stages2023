<?php
    include '../inc.connexion.php';

    $sqlmodif = "UPDATE `sta_periode` SET `date_debut`='".$_REQUEST['debutPeriode']."',`date_fin`='".$_REQUEST['finPeriode']."',`idclasse`='".$_REQUEST['promoPeriode']."' WHERE `idperiode`='".$_REQUEST['idPeriode']."'";
    $connection->exec($sqlmodif);
?>