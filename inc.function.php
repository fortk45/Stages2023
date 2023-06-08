<?php 
function getNbStagesSio1(){
    include "inc.connexion.php";
    $sqlstagesio1 = "SELECT COUNT(*) FROM sta_etudiant WHERE convention IS NOT NULL AND idclasse = 1;";
    $q10 = $connection->query($sqlstagesio1);
    $reponse10 = $q10->fetch();
    return $reponse10[0];
    
}
// SELECT COUNT(*) FROM sta_etudiant WHERE accordStage IS NOT NULL AND idclasse = 2;
function getNbStagesSio2() {
    include "inc.connexion.php";
    $sqlstagesio2 = "SELECT COUNT(*) FROM sta_etudiant WHERE convention IS NOT NULL AND idclasse = 2;";
    $q20 = $connection->query($sqlstagesio2);
    $reponse20 = $q20->fetch();
    
    return $reponse20[0];
}

function getNbElevesSio1(){
    include "inc.connexion.php";
    $sqlsio1 = "SELECT COUNT(*) FROM sta_etudiant WHERE idclasse = 1";
    $q11 = $connection->query($sqlsio1);
    $reponse11 = $q11->fetch();
    return $reponse11[0];
}

function getNbElevesSio2(){
    include "inc.connexion.php";
    $sqlsio2 = "SELECT COUNT(*) FROM sta_etudiant WHERE idclasse = 2";
    $q22 = $connection->query($sqlsio2);
    $reponse22 = $q22->fetch();
    return $reponse22[0];
}

function getEtudiantSansStage(){
    include "inc.connexion.php";
    $sqleleve = "SELECT * FROM sta_etudiant etu, sta_classe c WHERE etu.idclasse=c.idclasse AND ((idetudiant not in (SELECT idetudiant FROM sta_demande WHERE idetat = 4)) ) AND etu.idclasse not in (3,4) ORDER BY etu.idclasse desc,etu.nom asc ";
    //$sqleleve = "SELECT * FROM sta_etudiant etu, sta_classe c WHERE etu.idclasse=c.idclasse AND ((idetudiant not in (SELECT idetudiant FROM sta_demande)) OR ( idetudiant in (SELECT idetudiant FROM sta_demande WHERE idetat <> 4))) AND etu.idclasse not in (3,4) ORDER BY etu.idclasse desc,etu.nom asc";
    $q = $connection->query($sqleleve);
    $reponse2 = $q->fetchAll();
    return $reponse2;
}

function getEtudiantAvecStage(){
    include "inc.connexion.php";
    $sqleleve = "SELECT * FROM sta_etudiant etu, sta_classe c WHERE etu.idclasse=c.idclasse AND ( idetudiant in (SELECT idetudiant FROM sta_demande WHERE idetat = 4)) AND etu.idclasse not in (3,4) ORDER BY etu.idclasse desc,etu.nom asc";
    $q = $connection->query($sqleleve);
    $reponse4 = $q->fetchAll();
    return $reponse4;
}

function getHistoriqueStage(){
    include "inc.connexion.php";
    $sqlrecherche = "SELECT * FROM sta_demande d, sta_etudiant etu, sta_etat eta, sta_entreprise ent, sta_periode p WHERE p.idperiode=d.idperiode AND ent.identreprise=d.identreprise AND etu.idetudiant = d.idetudiant AND d.idetat =eta.idetat AND etu.idetudiant =".$_SESSION['code']." ORDER BY d.date_demande desc";
    $qq = $connection->query($sqlrecherche);
    $reponse3 = $qq->fetchAll();
    return $reponse3;
}

//Méthode qui va récupérer toutes les périodes arrivants plus tard qu'aujourd'hui.
function getFuturPeriode(){
    include "inc.connexion.php";
    $sql = "SELECT * FROM sta_periode where date_fin > now()";
    $q = $connection->query($sql);
    $ligne = $q->fetchAll();
    return $ligne;
}

function getEntreprise(){
    include 'inc.connexion.php';
    $sql = "SELECT identreprise, nom FROM sta_entreprise ORDER BY nom asc";
    $q = $connection->query($sql);
    $ligne = $q->fetchAll();
    return $ligne;
}

function getEtat(){
    include 'inc.connexion.php';
    $sql = "SELECT * FROM sta_etat";
    $q = $connection->query($sql);
    $ligne = $q->fetchAll();
    return $ligne;
}

function getNaf(){
    include 'inc.connexion.php';
    $sql = "SELECT * FROM sta_naf order by libelle_NAF asc";
    $q = $connection->query($sql);
    $ligne = $q->fetchAll();
    return $ligne;
}
// Récupère toutes les demandes de stage effectuées.
function getDemandeStage(){
    include 'inc.connexion.php';
    $sql = "SELECT * FROM sta_demande";
    $q = $connection->query($sql);
    $ligne = $q->fetchAll();
    return $ligne;
}
function getDemandeStageEleve($ideleve){
    include 'inc.connexion.php';
    $sql = "SELECT * FROM sta_demande WHERE idetudiant=.$ideleve";
    $q = $connection->query($sql);
    $ligne = $q->fetchAll();
    return $ligne;
}
function getClasseSio(){
    include 'inc.connexion.php';
    $sql = "SELECT * FROM `sta_classe` WHERE idclasse=1 OR idclasse=2 ";
    $q = $connection->query($sql);
    $ligne = $q->fetchAll();
    return $ligne;
}
?>