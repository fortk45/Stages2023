<!DOCTYPE html>
<html>

<?php 
session_start();
    require "header.php";
    include 'inc.connexion.php';
    //Lie bien l'input de l'email à la variable codeconnect
    if (isset($_REQUEST['email'])){
        $codeconnect = htmlspecialchars($_REQUEST['email']);
        if (empty($codeconnect)){
            $error = "Veuillez entrer une adresse mail";
        } else {
            //Requête afin de sélectionner l'email dans la BDD correspondant à l'email mis dans codeconnect
            $table = $connection->prepare("SELECT email, prenom, idetudiant FROM sta_etudiant Where email=:codeconnect");
            $table->bindparam(':codeconnect', $codeconnect);
            $table->execute();
            $affiche = $table->fetch();
        
            //Création automatisée du Token, clé primaire de la demande de réinitialisation de mot de passe
            $token = bin2hex(random_bytes(20));
            $_SESSION['token'] = $token;

            //Si le résultat de la requête diffère de l'email entré dans codeconnect
            if(!isset($affiche["email"])){
                $error = "Votre adresse mail est inexistante dans notre système";
            } else {            
                //Insertion de la requête de réinitialisation dans la BDD
                
                header('location: mailReset.php?mail='.$codeconnect.'&prenom='.$affiche['prenom'].'&id='.$affiche['idetudiant']);
                
            }
        }
    }

?>

<!-- Mise en place du formulaire de la réinitialisation du mot de passe -->
<div class="page login-page">
    <div class="container">
        <div class="row">
            <div class="form-outer text-center d-flex align-items-center">
                <div class="form-inner">
                    <div class="logo text-uppercase"><img id="bark" src="img/brk.jpg">
                    </div>
                    <form class="login-form" action="" method="get" class="text-left form-validate">
                        <h2 class="form-title">Réinitialisation du mot de passe</h2>
                        <!-- form validation messages -->
                        <div class="form-group">
                            <input id="email" type="email" name="email" class="input-material" placeholder="Adresse mail du compte :">
                        </div>
                        <div class="form-group">
                            <div class="form-group text-center"><input type="submit" name="reset-password" href="inc.reset.php"
                                                   class="btn btn-primary" value="Envoyer">
                            </div>
                        </div>
                    </form>
                    <?php 
                    if (isset($error)){
                        echo "<div style='width: 250px;display: block;margin: auto;color:#c81919'>".$error."</div>";
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<!--Avant, ça allait sur inc.reset.php, mais ça, c'était avant-->