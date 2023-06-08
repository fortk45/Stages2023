<?php
    include '../inc.connexion.php';
    
    $sqldelete = "DELETE FROM sta_periode WHERE idperiode=".$_REQUEST['idPeriode'];
    $q = $connection->exec($sqldelete);
    
    
?>