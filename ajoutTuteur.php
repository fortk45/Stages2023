<?php

include "inc.connexion.php";

//if (session_status() == PHP_SESSION_NONE) { //Evite une erreur dans le cas ou la session est deja existante
//    session_start(); // Si session status = none alors start() sinon continue
//}
if (!isset($_SESSION)) { session_start(); }
if (isset($_REQUEST['nomContact']) && isset($_REQUEST['prenomContact']) && isset($_REQUEST['idEnt'])) {
$nomTuteur = $_REQUEST['nomContact']." ".$_REQUEST['prenomContact'];
$sqlAddContact = 'INSERT INTO sta_contact(`nom`, `prenom`, `tel`, `mail`, `role`, `service`, `identreprise`) 
    VALUES(:nomContact,
    :prenomContact,
    :telContact,
    :mailContact,
    :roleContact,
    :serviceContact,
    :idEnt)';

$newContact = $connection->prepare($sqlAddContact);
$newContact->bindParam(':nomContact', $_REQUEST['nomContact'], PDO::PARAM_STR);
$newContact->bindParam(':prenomContact', $_REQUEST['prenomContact'], PDO::PARAM_STR);
$newContact->bindParam(':telContact', $_REQUEST['telContact'], PDO::PARAM_STR);
$newContact->bindParam(':mailContact', $_REQUEST['mailContact'], PDO::PARAM_STR);
$newContact->bindParam(':roleContact', $_REQUEST['roleContact'], PDO::PARAM_STR);
$newContact->bindParam(':serviceContact', $_REQUEST['serviceContact'], PDO::PARAM_STR);
$newContact->bindParam(':idEnt', $_REQUEST['idEnt'], PDO::PARAM_INT);
$newContact->execute();

$_SESSION['ajoutTuteurOk']=True;
$_SESSION['nomTuteur'] = $nomTuteur;
header('Location: ' . $_SERVER['HTTP_REFERER']);
} ?>