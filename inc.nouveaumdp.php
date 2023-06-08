<?php
session_start();
include 'inc.connexion.php';

if (!isset($_REQUEST['token'])){
    header('location: login.php');
    die();
}

if ((isset($_REQUEST['newpassword'])) && (isset($_REQUEST['newpassword_c'])) 
&& ($_REQUEST['newpassword'] == $_REQUEST['newpassword_c'])){
    $newmdp = MD5(htmlspecialchars($_REQUEST['newpassword']));
} else {
    header('location: login.php');
    die();
}

$token = $_REQUEST['token'];
//Lie le premier password rentré dans le formulaire a la variable newmdp
$requeteToken = $connection->prepare("SELECT idetudiant FROM `sta_reset` WHERE token=:token");
$requeteToken->bindparam(':token', $token);
$requeteToken->execute();
$tokenMail = $requeteToken->fetch();

if (!empty($tokenMail)){
    $idetudiant = $tokenMail[0];
} else {
    header('location: login.php');
    die();
}


//S'assure de la bonne concordance des emails entre l'utilisateur et ce qui a été précedemment mis dans les variables de session (sécurité)
//Met à jour correctement le bon utilisateur faisant le reset de MDP
$changeMDP = $connection->prepare("UPDATE sta_etudiant SET mdp=:newmdp WHERE idetudiant=:idetudiant;");
$changeMDP->bindparam(':newmdp', $newmdp);
$changeMDP->bindparam(':idetudiant', $idetudiant);
$changeMDP->execute();

//Supprime le token pour le reset dans la BDD
$noNeedToken = $connection->prepare("DELETE FROM sta_reset WHERE token=:token");
$noNeedToken->bindparam(':token', $token);
$noNeedToken->execute();

header("Location: login.php");
die();