<?php 
session_start();
include "../inc.connexion.php";

if ($_SESSION['idclasse'] == 3) {
    $userCheck = 'Admin';
} else if($_SESSION['idclasse'] == 2 || $_SESSION['idclasse'] == 1) {
    $userCheck = 'Client';
} else {
    header("Location: login.php");
}
if ($userCheck == 'Client') {
?>
<?php
$idEtudiant = $_SESSION['code'];
$nomEtudiant = $_REQUEST['updateNomEtudiant'];
$prenomEtudiant = $_REQUEST['updatePreomEtudiant'];
$mailEtudiant = $_REQUEST['updateMailEtudiant'];
$classeEtudiant = $_REQUEST['updateClasseEtudiant'];
$mdpEtudiant = $_REQUEST['updateMdpEtudiant'];
}
if($userCheck == 'Admin'){
    $idEtudiant = $_SESSION['updateEtudiant'];
    $nomEtudiant = $_REQUEST['updateNomEtudiant'];
    $prenomEtudiant = $_REQUEST['updatePreomEtudiant'];
    $mailEtudiant = $_REQUEST['updateMailEtudiant'];
    $classeEtudiant = $_REQUEST['updateClasseEtudiant'];
    $mdpEtudiant = $_REQUEST['updateMdpEtudiant'];
}

$insert = "UPDATE sta_etudiant SET nom=:nom, prenom=:prenom, email=:email, idclasse=:classe WHERE idetudiant=:idEtudiant";
$insertPrepare = $connection->prepare($insert);

    $insertPrepare->bindParam(':nom',$nomEtudiant);                                   
    $insertPrepare->bindParam(':prenom',$prenomEtudiant);                                  
    $insertPrepare->bindParam(':classe',$classeEtudiant);                                 
    $insertPrepare->bindParam(':email', $mailEtudiant);
    $insertPrepare->bindParam(':idEtudiant',$idEtudiant); 
    
    $insertPrepare->execute();

// Vérifier si le formulaire a été soumis
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_FILES["updateImageEtudiant"])){
        // Vérifie si le fichier a été uploadé sans erreur.
        if(isset($_FILES["updateImageEtudiant"]) && $_FILES["updateImageEtudiant"]["error"] == 0){
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png", "PNG" => "image/PNG");
            $filename = $_FILES["updateImageEtudiant"]["name"];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $filename = preg_replace('/[^a-zA-Z0-9-_\.]/', '-', $filename);
            $newname = $idEtudiant."_".$filename;
            $filetype = $_FILES["updateImageEtudiant"]["type"];
            $filesize = $_FILES["updateImageEtudiant"]["size"];
            // Vérifie l'extension du fichier
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)){
                header("Location: erreur.html");
                exit();
            }

            // Vérifie la taille du fichier - 5Mo maximum
            $maxsize = 5 * 1024 * 1024;
            if($filesize > $maxsize) die(header("Location: erreur-taille.html"));

            // Vérifie la taille de l'image - 3000px maximum pour chaque dimension
            $maxdim = 3000;
            list($width, $height) = getimagesize($_FILES["updateImageEtudiant"]["tmp_name"]);
            if ($width > $maxdim || $height > $maxdim) die(header("Location: erreur-taille.html"));


            // Vérifie le type MIME du fichier
            if(in_array($filetype, $allowed)){   
                $increment = 1;         
                $newname = $idEtudiant."_".$_FILES["updateImageEtudiant"]["name"];
                // Vérifie si le fichier existe avant de le télécharger.
                if(move_uploaded_file($_FILES["updateImageEtudiant"]["tmp_name"], "../img/avatar/".$newname)) {
                    $insert2 = "UPDATE sta_etudiant SET photo=:nouvNom WHERE idetudiant=:idEtudiant";
                    $insert2Prepare = $connection->prepare($insert2);

                    $insert2Prepare->bindParam(':nouvNom',$newname);                                                                  
                    $insert2Prepare->bindParam(':idEtudiant',$idEtudiant); 
                    
                    $insert2Prepare->execute();
                    
                } else {
                    echo "Erreur d'upload ! Le fichier a bien été upload mais dans le mauvais repertoire !";
                } 
            } else{
                echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."; 
            }
        } else{
            echo "Error: " . $_FILES["updateImageEtudiant"]["error"];
        }
    }
}

header('Location: ../eleve.php?ideleve='.$idEtudiant);
?>