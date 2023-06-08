<?php
include 'inc.connexion.php';

//Lie bien l'input de l'email à la variable codeconnect
$codeconnect = htmlspecialchars($_REQUEST['email']);
$_SESSION['email'] = $codeconnect;

//Requête afin de sélectionner l'email dans la BDD correspondant à l'email mis dans codeconnect
$requete = "SELECT email FROM sta_etudiant Where email='$codeconnect'";
$table = $connection->query($requete);
$ligne = $table->fetch();

//Création automatisée du Token, clé primaire de la demande de réinitialisation de mot de passe
$token = bin2hex(random_bytes(50));
$_SESSION['token'] = $token;


//Si codeconnect est vide, que donc rien n'a été rentré
if(empty($codeconnect)){

    array_push($errors, "Votre email est nécessaire");
    echo("Raté1");

} else {
    //Si le résultat de la requête diffère de l'email entré dans codeconnect
    if(!isset($ligne["email"])){
        array_push($errors, "Votre mail est inexistante dans notre système");
        echo("Raté2");
    } else {
        //Si codeconnect n'est pas vide, que l'email correspond bien à celui entré par l'utilisateur
        if($ligne["email"] == $codeconnect){
    
            //Insertion de la requête de réinitialisation dans la BDD
            $requete2 = $connection->query("INSERT INTO sta_reset(email,token) VALUES ('$codeconnect', '$token');");
    
            //Variables nécessaires à l'envoi d'email
            $to = $codeconnect;
            $subject = "Reinitialisation de votre mot de passe sur SuiviStageProjet.com";
            $message = "Bonjour, merci de cliquer sur le lien suivant afin de reinitialiser votre mot de passe : https://172.20.254.246:8000/nouveau_pass.php?token=". $token;
            $message = wordwrap($message, 70, "\r\n");
            $headers = 'From: infostagesstpbb@gmail.com';
            mail($to, $subject, $message, $headers);
    
            //template = template_7argk8m
    
            //Renvoi sur la page d'attente après envoi de la requête
            header("Location: attente.php");
    
        }
    }

}