<?php
include '../inc.connexion.php';

$idEnt = ;

$sqlTuteur = "SELECT * FROM sta_contact WHERE identreprise=".$idEnt;
$q = $connection->query($sqlperiode);
$reponse = $q->fetchAll();


foreach($reponse as $affiche){
    $nomTuteur = $affiche["nom"].$affiche["prenom"];

    $txt = "<option>".$nomTuteur."</option>";
    $reponse = $reponse.$txt;
}
echo $reponse;

?>


