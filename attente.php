<?php 
    require "header.php";
?>

<!-- Mise en place du message confirmant bien l'envoi du mail de réinitialisation de mot de passe -->
<div class="page login-page">
    <div class="container">
        <div class="row">
            <div class="form-outer text-center d-flex align-items-center">
                <div class="form-inner">
                    <form class="login-form" action="login.php" method="post" style="text-align: center;">
                        <p>
                            Nous venons d'envoyer un mail à  <b><?php session_start(); echo $_SESSION['email']; ?></b> pour vous aider à récupérer votre compte.
                        </p>
                        <p>Merci de bien vous connecter à votre boîte mail, et cliquer sur le lien fourni dans notre mail afin de réinitialiser votre mot de passe ! </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>