<?php
    include '../inc.connexion.php';
    $sql = "DELETE FROM sta_promotion WHERE id_promotion ='".$_REQUEST['idPromo']."'";
    $connection->exec($sql);
    header('Location: ../gestionPromotions.php');
    