<?php
//if (session_status() == PHP_SESSION_NONE) { //Evite une erreur dans le cas ou la session est deja existante
//    session_start(); // Si session status = none alors start() sinon continue
//}
if (!isset($_SESSION)) { session_start(); }    
if ($_SESSION['idclasse'] == 3) {
    $userCheck = 'Admin';
} else if($_SESSION['idclasse'] == 2 || $_SESSION['idclasse'] == 1) {
    $userCheck = 'Client';
} else {
    header("Location: login.php");
}
if ($userCheck == 'Client') {
    header("Location : index.php");
    }
?>

<?php

if ($userCheck == 'Admin') {
    include 'inc.header.php';
    //recup idEntreprise dans URL
    $idEntreprise = $_REQUEST['identreprise'];
    ##########################################
    //recup de date_demande, libelle_etat, raison du refus, nom et prenom de l eleve, date debut & fin du stage
    $sqlEntreprise = "select d.date_demande, et.libelle_etat,d.raisonRefus, e.nom as nomEleve, e.prenom as prenomEleve, p.date_debut, p.date_fin from sta_demande d, sta_entreprise ent, sta_etudiant e, sta_periode p, sta_etat et where d.idcontact IN (SELECT idcontact FROM sta_contact WHERE identreprise=ent.identreprise) and p.idperiode = d.idperiode and e.idetudiant = d.idetudiant and et.idetat = d.idetat and d.idcontact IN (SELECT idcontact FROM sta_contact WHERE identreprise=".$idEntreprise.");";
    $queryEntreprise = $connection->query($sqlEntreprise);
    $reponseEntreprise = $queryEntreprise->fetchAll();



    //Recup nom entreprise selectionne
    $sqlNomEntreprise = "select distinct ent.nom from sta_entreprise ent where ent.identreprise =".$idEntreprise;
    $queryNomEntreprise = $connection->query($sqlNomEntreprise);
    $ligneNomEntreprise = $queryNomEntreprise->fetch();



    ?>
    <section class="">
        <div class="container-fluid">
            <header>
            </header>

            <div class="card">
                <div class="card-header">
                    <h4>Demandes liées a l'entreprise : <?php echo $ligneNomEntreprise['nom'];?></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table1">
                            <thead>
                            <tr class="ligne">
                                <th>Date de la Demande</th>
                                <th>Etat</th>
                                <th>Raison Refus</th>
                                <th>Eleve</th>
                                <th>Periode</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($reponseEntreprise as $affiche){
                                $dateDemande = $affiche["date_demande"];
                                $periode = $affiche["date_debut"]." au ".$affiche['date_fin'];
                                $refus = $affiche["raisonRefus"];
                                $nomEtudiant = $affiche['nomEleve']." ".$affiche['prenomEleve'];
                                $etat = $affiche["libelle_etat"];
                            ?>
                                <tr class="ligne">
                                    <td><?php echo $periode;?></td>
                                    <td><?php echo $etat;?></td>
                                    <td><?php echo $refus?></td>
                                    <td><?php echo $nomEtudiant?></td>
                                    <td><?php echo $periode?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                </div>
                </div>
                </div>
                </div>
<?php }

include 'inc.footer.php' ?>

