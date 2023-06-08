<?php
include "inc.header.php";
include "inc.connexion.php";
?>
<?php
$idetudiant = $_GET["ideleve"];
$sqlEleve = "SELECT e.nom, e.prenom, e.idclasse FROM sta_etudiant e where e.idetudiant =".$idetudiant;
$sqlRes = $connection -> query($sqlEleve);
$ligne = $sqlRes->fetch();
$nomEtudiant =  $ligne['nom']." ".$ligne['prenom'];
$classeEtudiant = $ligne['idclasse'];
$sqlsio = "select p.date_debut, p.date_fin,ent.nom, p.idclasse, d.raisonRefus, et.libelle_etat from sta_periode p, sta_entreprise ent, sta_demande d, sta_etat et where p.idperiode = d.idperiode and et.idetat = d.idetat and ent.identreprise IN (SELECT identreprise FROM `sta_contact` WHERE `idcontact`= d.idcontact) and d.idetudiant =".$idetudiant;
//$sqlsio1 = "select p.date_debut, p.date_fin,ent.nom, p.promoPeriode, d.raisonRefus, et.libelle_etat from sta_periode p, sta_entreprise ent, sta_demande d, sta_etat et where p.idperiode = d.idperiode and et.idetat = d.idetat and ent.identreprise = d.identreprise and d.idetudiant = ".$idetudiant." and p.promoPeriode = \"SIO1\"";
$qsio = $connection->query($sqlsio);
$reponsesio = $qsio->fetchAll();
//$qsio1 = $connection->query($sqlsio1);
//$reponsesio1 = $qsio1->fetchAll();

?>
<section class="">
    <div class="container-fluid">
        <header>
        </header>

        <div class="card">
            <div class="card-header">
                <h4><?php echo $nomEtudiant?></h4>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <?php
                    if($ligne['idclasse'] == 2){
                        echo "<table class='table table-striped' name='SIO2'>
                            <label for name='SIO2'>SIO2</label>
                            <thead>
                            ";
                    }else{
                        echo"<table class='table table-striped' name='SIO1'>
                            <label for name='SIO1'>SIO1</label>
                            <thead>";
                    }?>
                                <tr>
                                    <th>Période</th>
                                    <th>Entreprise</th>
                                    <th>Etat</th>
                                    <th>Raison Refus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($reponsesio as $affiche){
                                    $periode = $affiche["date_debut"]." au ".$affiche['date_fin'];
                                    $nomEntreprise = $affiche["nom"];
                                    $refus = $affiche["raisonRefus"];
                                    $etat = $affiche["libelle_etat"];
                                    ?>
                                    <tr>
                                        <td><?php echo $periode;?></td>
                                        <td><?php echo $nomEntreprise;?></td>
                                        <td><?php echo $etat?></td>
                                        <td><?php echo $refus?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</section>
<?php include 'inc.footer.php' ?>
