<?php
include '../inc.connexion.php';
################################################
//PARTIE INSERTION

$sqlAddTut = 'INSERT INTO sta_contact(`nom`, `prenom`, `tel`, `Mail`, `role`, `service`, `identreprise`) 
    VALUES(:nomContact2,
    :prenomContact2,
    :telContact2,
    :mailContact2,
    :roleContact2,
    :serviceContact2,
    :idEnt2)';

$newContact = $connection->prepare($sqlAddTut);
$newContact->bindParam(':nomContact2', $_GET['nomContact2'], PDO::PARAM_STR);
$newContact->bindParam(':prenomContact2', $_GET['prenomContact2'], PDO::PARAM_STR);
$newContact->bindParam(':telContact2', $_GET['telContact2'], PDO::PARAM_STR);
$newContact->bindParam(':mailContact2', $_GET['mailContact2'], PDO::PARAM_STR);
$newContact->bindParam(':roleContact2', $_GET['roleContact2'], PDO::PARAM_STR);
$newContact->bindParam(':serviceContact2', $_GET['serviceContact2'], PDO::PARAM_STR);
$newContact->bindParam(':idEnt2', $_GET['idEnt2'], PDO::PARAM_INT);
$newContact->execute();
$lastId = $connection->lastInsertId();

################################################

################################################
// PARTIE AFFICHAGE
$sqlSelectTut = 'select nom, prenom, idcontact from sta_contact where identreprise=:idEnt2';
$recuperateTut = $connection->prepare($sqlSelectTut);
$recuperateTut->bindParam(':idEnt2', $_GET['idEnt2'], PDO::PARAM_INT);
$recuperateTut->execute();
$ligne = $recuperateTut->fetchAll();

$txt = '';
foreach($ligne as $affiche){
    $idTuteur = $affiche["idcontact"];
    $nomTuteur = $affiche["nom"]." ".$affiche["prenom"];
    $txt = $txt."<option value =".$idTuteur;
    if ($affiche["idcontact"]==$lastId){
        $txt = $txt." selected";
    }
    $txt = $txt.">".$nomTuteur."</option>";
}
echo $txt;
################################################
?>