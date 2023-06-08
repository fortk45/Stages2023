<?php

include "inc.connexion.php";

//if (session_status() == PHP_SESSION_NONE) { //Evite une erreur dans le cas ou la session est deja existante
//    session_start(); // Si session status = none alors start() sinon continue
//}

if (!isset($_SESSION)) { session_start(); }
if (isset($_REQUEST['siretEnt']) && isset($_REQUEST['nomEnt']) && isset($_REQUEST['nafEnt']) && isset($_REQUEST['telEnt']) && isset($_REQUEST['mailEnt']) && isset($_REQUEST['cpEnt']) && isset($_REQUEST['villeEnt'])) {

$nomEnt = $_REQUEST['nomEnt'];

$sqlAddEnt = 'INSERT INTO sta_entreprise(SIRET, nom, codeNAF, tel, Mail, cpville, ville) 
    VALUES(:siret,
    :nom,
    :naf,
    :tel,
    :mail,
    :cp,
    :ville)';
    
$newEntreprise = $connection->prepare($sqlAddEnt);
$newEntreprise->bindParam(':siret', $_REQUEST['siretEnt'], PDO::PARAM_STR);
$newEntreprise->bindParam(':nom', $_REQUEST['nomEnt'], PDO::PARAM_STR);
$newEntreprise->bindParam(':naf', $_REQUEST['nafEnt'], PDO::PARAM_STR);
$newEntreprise->bindParam(':tel', $_REQUEST['telEnt'], PDO::PARAM_STR);
$newEntreprise->bindParam(':mail', $_REQUEST['mailEnt'], PDO::PARAM_STR);
$newEntreprise->bindParam(':cp', $_REQUEST['cpEnt'], PDO::PARAM_STR);
$newEntreprise->bindParam(':ville', $_REQUEST['villeEnt'], PDO::PARAM_STR);
$newEntreprise->execute();

$_SESSION['ajoutEntOk']=True;
$_SESSION['nomEnt'] = $nomEnt;

header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>
