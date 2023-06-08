<?php
session_start();
include 'inc.connexion.php';

$codeconnect = htmlspecialchars($_REQUEST['email']);
$mdpconnect = MD5($_REQUEST['mdp']);

//vérifier si le mail existe dans la base de donnée avant de vérifier le mot de passe

$requete = $connection->prepare("SELECT email, failed_login FROM sta_etudiant Where email =:email;");
$requete->bindParam(':email', $codeconnect);
$requete->execute();
$userExisting = $requete->fetch();

if (!$userExisting){
    //Si le compte n'existe pas
    //Erreur 1 : Compte inexistant (renvoi à la page de connexion)
    header("Location: login.php?codeError=1");
} else {
    //SI LE COMPTE EXISTE

    if ($userExisting['failed_login']>=20) {
        //S'il y a trop de tentatives de connexion
        //Erreur 3 : Trop de tentatives de connexion
        header("Location: login.php?codeError=3");
    } else {
        //S'il n'y a pas trop de tentatives de connexion
        $requete = $connection->prepare("SELECT mdp, failed_login FROM sta_etudiant Where email =:email AND mdp = :mdp;");
        $requete->bindParam(':email', $codeconnect);
        $requete->bindParam(':mdp', $mdpconnect);
        $requete->execute();
        $mdp = $requete->fetch();
        if (!$mdp){
            //Si le mot de passe n'est pas bon
            //On incrémente de un le nombre de tentatives ratées
            $requete = $connection->prepare("UPDATE `sta_etudiant` SET `failed_login` = `failed_login`+1 WHERE `email` = :email;");
            $requete->bindParam(':email', $codeconnect);
            $requete->execute();
            $requete->fetch();
            // Erreur 2 : mot de passe incorrect (renvoi à la page de connexion)
            header("Location: login.php?codeError=2");
        } else {
            //SI LE MOT DE PASSE EST BON

            var_dump($mdp['failed_login']>=20);
            //Récupérer les informations de l'élève
            $requser = $connection->prepare("SELECT * FROM sta_etudiant,sta_classe WHERE sta_etudiant.idclasse=sta_classe.idclasse AND email = :email;");
            $requser->bindParam(':email', $codeconnect);
    
            $requser->execute();
            $userexist = $requser->rowCount();
            if ($userexist == 1) {
                $userinfo = $requser->fetch();
                $_SESSION['code'] = $userinfo['idetudiant'];
                $_SESSION['nom'] = $userinfo['nom'];
                $_SESSION['prenom'] = $userinfo['prenom'];
                $_SESSION['anneePro'] = $userinfo['anneePro'];
                $_SESSION['mail'] = $codeconnect;
                $_SESSION['photo'] = $userinfo['photo'];
                $_SESSION['idclasse'] = $userinfo['idclasse'];
                $_SESSION['nomClasse'] = $userinfo['libelle_classe'];
                unset($_SESSION['erreur']);
                header("Location: index.php");
            } else {
                //Erreur 1 : Erreur jesépasekisépassémélédonéonchangémonreuftespudanlabasededonneee (renvoi à la page de connexion)
                header("Location: login.php?codeError=4");
            }
        }
    }
}

//permet de se connecter avec son compte au site

?>
