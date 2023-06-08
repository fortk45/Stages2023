<?php

include "inc.connexion.php";

//if (session_status() == PHP_SESSION_NONE) { //Evite une erreur dans le cas ou la session est deja existante
//    session_start(); // Si session status = none alors start() sinon continue
//}
if (!isset($_SESSION)) { session_start(); }

if (isset($_REQUEST['dateDem']) && isset($_REQUEST['idperiode']) 
    && isset($_REQUEST['idContact']) && isset($_REQUEST['idetat'])) {

    if (isset($_REQUEST['refusDem'])) {
        $refus = $_REQUEST['refusDem'];
    } else {
        $refus = "";
    }

    $dateDem = $_REQUEST['dateDem'];
    $code = $_SESSION['code'];
    $idetat = $_REQUEST['idetat'];
    $idContact = $_REQUEST['idContact'];
    $identreprise = $_REQUEST['idEnt'];
    $idperiode = $_REQUEST['idperiode'];

    $sqlAddDem = 'INSERT INTO sta_demande(date_demande, idetudiant, idetat, idcontact, identreprise, idperiode, raisonRefus) 
                    VALUES (:dateDem,:code,:idetat,:idContact,:idEnt,:idperiode,:refus)';
    $newDemande = $connection->prepare($sqlAddDem);

    $newDemande->bindParam(':dateDem', $dateDem);
    $newDemande->bindParam(':code', $code);
    $newDemande->bindParam(':idetat', $idetat);
    $newDemande->bindParam(':idContact', $idContact);
    $newDemande->bindParam(':idEnt', $identreprise);
    $newDemande->bindParam(':idperiode', $idperiode);
    $newDemande->bindParam(':refus', $refus);;
    $newDemande->execute();

    $_SESSION['ajoutDemandeOk']=True;

    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>

