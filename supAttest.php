<?php
require "inc.connexion.php"; 

if ( isset ($_POST['submit'])) {
    $idEtud = $_POST['idEtu'];
    
    // Récupérez le nom de la photo à supprimer dans la base de données
    $select = "SELECT attestStage FROM sta_etudiant WHERE idetudiant = $idEtud";
    $stmt = $connection->prepare($select);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $filename = $result['attestStage'];

    // Supprimez la photo de la base de données
    $delete = "UPDATE sta_etudiant SET attestStage = NULL WHERE idetudiant = $idEtud";
    $stmt = $connection->prepare($delete);
    $stmt->execute();

    // Supprimez la photo du serveur
    $path='justificatifs/attestation/';
    $filepath = $path . $filename;
    if (file_exists($filepath)) {
        unlink($filepath);
    }

    header('Location: gestionEleves.php');
} else { 
    header('Location: gestionEleves.php');
}
?>
