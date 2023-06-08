<!-- PAGE A INCLURE A CHAQUE FOIS QU'ON EST SUR UNE PAGE A LAQUELLE SEUL L'ADMIN DEVRAIT ACCEDER -->
<!-- REDIRIGE VERS L'INDEX SI L'UTILISATEUR N'EST PAS ADMIN -->
<?php
if (!isset($_SESSION)) { session_start(); } //démarrer la session si ce n'est pas déjà le cas 

if ($_SESSION['idclasse'] == 3) {
    $userCheck = 'Admin';
} else {
    header("Location:index.php");
    die();
}
?>