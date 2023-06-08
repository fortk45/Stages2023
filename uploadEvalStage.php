<?php
require "inc.connexion.php"; 

if (isset($_FILES["eval"])){
    $nomEtudiant = $_POST['nom'];
    $idEtudiant = $_POST['idEtu'];

    // Extensions de fichiers autorisées
    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png", "pdf" => "image/pdf");
     // Récupérez les données du fichier
    $filename = $_FILES["eval"]["name"];
    $filetmpname = $_FILES["eval"]["tmp_name"];
    $filesize = $_FILES["eval"]["size"];

    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if(!array_key_exists($ext, $allowed)){
        header("Location: data/erreur.html");
        exit();
    }

    // Vérifiez si il y a eu une erreur lors de l'upload
    
        // Vérifiez la taille maximale du fichier (2 Mo)
        if ($filesize < 2000000) {
            // Générez un nom de fichier unique
            $newname = $idEtudiant."_".$nomEtudiant."_".$filename;

            // Définissez le chemin de stockage du fichier
            $fileDestination = 'justificatifs/eval/' . $newname;

            // Déplacez le fichier de sa source temporaire à sa destination finale
            move_uploaded_file($filetmpname, $fileDestination);

            // Préparez la requête SQL pour insérer les données dans la base de données
            $insert = "UPDATE sta_etudiant SET eval = '$newname' WHERE idetudiant = $idEtudiant";
            $stmt = $connection->prepare($insert);
            $stmt->execute();

            header("Location: data/telechReussi");
        } else {
            echo "Le fichier est trop volumineux (taille maximale: 2 Mo).";
        }
    
    
} else {
    echo "erreuuuur";
}

?>