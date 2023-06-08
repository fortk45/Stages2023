<?php
include '../inc.connexion.php';
################################################
//PARTIE INSERTION

$sqlAddEnt = 'INSERT INTO sta_entreprise(SIRET, nom, codeNAF, tel, Mail, cpville, ville) 
    VALUES(:siret2,
    :nom2,
    :naf2,
    :tel2,
    :mail2,
    :cp2,
    :ville2)';

$newEntreprise = $connection->prepare($sqlAddEnt);
$newEntreprise->bindParam(':siret2', $_GET['siret2'], PDO::PARAM_STR);
$newEntreprise->bindParam(':nom2', $_GET['nom2'], PDO::PARAM_STR);
$newEntreprise->bindParam(':naf2', $_GET['naf2'], PDO::PARAM_STR);
$newEntreprise->bindParam(':tel2', $_GET['tel2'], PDO::PARAM_STR);
$newEntreprise->bindParam(':mail2', $_GET['mail2'], PDO::PARAM_STR);
$newEntreprise->bindParam(':cp2', $_GET['cp2'], PDO::PARAM_STR);
$newEntreprise->bindParam(':ville2', $_GET['ville2'], PDO::PARAM_STR);
$newEntreprise->execute();
$lastId = $connection->lastInsertId();

################################################

################################################
// PARTIE AFFICHAGE
$sqlSelectEnt = 'SELECT identreprise, nom FROM sta_entreprise ORDER BY nom asc';
$recuperateEnt = $connection->prepare($sqlSelectEnt);
$recuperateEnt->execute();
$ligne = $recuperateEnt->fetchAll();

$txt = '';
foreach($ligne as $affiche){
    $idEnt = $affiche["identreprise"];
    $nomEnt = $affiche["nom"];
    $txt = $txt."<option value =".$idEnt;
    if ($affiche["identreprise"]==$lastId){
        $txt = $txt." selected";
    }
    $txt = $txt.">".$nomEnt."</option>";
}
echo $txt;
################################################
?>