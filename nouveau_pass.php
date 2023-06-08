<?php
session_start();
include 'inc.connexion.php';

if (!isset($_REQUEST['token'])){
    header('location: login.php');
    die();
} else {
    $token = $_GET['token'];
    $requeteToken = $connection->prepare("SELECT * FROM `sta_reset` WHERE token=:token");
    $requeteToken->bindparam(':token', $token);
    $requeteToken->execute();
    $verifToken = $requeteToken->fetch();
    if (empty($verifToken)){
        header('location: login.php');
        die();
    }
}
    
?>

<!DOCTYPE html>
<html>

<?php 
    require "header.php";
?>

<!-- Mise en place du formulaire de la réinitialisation du mot de passe -->
<div class="page login-page">
    <div class="container">
        <div class="row">
            <div class="form-outer text-center d-flex align-items-center">
                <div class="form-inner">
                    <!-- Mise en place du formulaire instituant le nouveau mot de passe -->
                    <form class="login-form" action="inc.nouveaumdp.php?token=<?php echo $token ?>" method="post">
                        <h2 class="form-title">Nouveau mot de passe !</h2>
                        <!-- form validation messages -->
                        <div class="form-group">
                            <label>Nouveau mot de passe</label>
                            <input type="password" name="newpassword">
                        </div>
                        <div class="form-group">
                            <label>Veuillez confirmer le nouveau mot de passe</label>
                            <input type="password" name="newpassword_c">
                        </div>
                        <div class="form-group">
                                <input type="submit"  class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>