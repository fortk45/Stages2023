<!--LA ! CEST LA !-->
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
?>
<section class="">
    <div class="container-fluid">
        <header>
        </header>

        <div class="card">
            <div class="card-header">
                <h4>Etudiants sans stage</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Etudiant</th>
                            <th>Classe</th>
                            <th>Rappel</th>
                            <th>Recherches de Stages</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach(getEtudiantSansStage() as $affiche){
                            $idEtudiant = $affiche['idetudiant'];
                            $nomEtudiant = $affiche['nom']." ".$affiche['prenom'];
                            $photoEtudiant = $affiche["photo"];
                            $classeEtudiant = $affiche["libelle_classe"];
                            ?>
                            <tr>
                                <td><img width="100" src="img/avatar/<?php echo $photoEtudiant?>">
                                    <?php echo $nomEtudiant;?></td>
                                <td><?php echo $classeEtudiant;?></td>
                                <td><a class="btn btn-primary" data-toggle="modal"
                                       data-target="#rappel<?php echo $idEtudiant?>" style="color: white"><i
                                            class="fas fa-bell"></i></a></td>
                                <td><a href="eleve.php?ideleve=<?php echo $idEtudiant; ?>" class="btn btn-primary"
                                       style="color: white"><i class="fas fa-address-card"></i></a></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>
<?php }
if ($userCheck == 'Admin') {
    //Cherche l id etudiant envoye depuis dashboard admin bouton recherche stage
    //$idetudiant = $_GET["ideleve"];
    ?>
    <section class="">
    <div class="container-fluid">
        <header>
        </header>

        <div class="card">
            <div class="card-header">
                <h4>Eleves Sans Stage</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table1">
                        <thead>
                        <tr class="ligne">
                            <th class="ligne">Etudiant</th>
                            <th class="ligne">Classe</th>
                            <th>Rappel</th>
                            <th>Recherches de Stages</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach(getEtudiantSansStage() as $affiche){
                            $idEtudiant = $affiche['idetudiant'];
                            $nomEtudiant = $affiche['nom']." ".$affiche['prenom'];
                            $photoEtudiant = $affiche["photo"];
                            $classeEtudiant = $affiche["libelle_classe"];
                            ?>
                            <tr class="ligne">
                                <td class ="<?php echo $classeEtudiant ?>"><img width="100" height="100" src="img/avatar/<?php echo $photoEtudiant?>">
                                    <?php echo $nomEtudiant;?></td>
                                <td class ="<?php echo $classeEtudiant ?>"><?php echo $classeEtudiant;?></td>
                                <td><a class="btn btn-primary" data-toggle="modal"
                                       data-target="#rappel<?php echo $idEtudiant?>" style="color: white"><i
                                            class="fas fa-bell"></i></a></td>
                                <td><a href="affichageDemandesEleve.php?ideleve=<?php echo $idEtudiant; ?>" class="btn btn-primary"
                                       style="color: white"><i class="fas fa-address-card"></i></a></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h4>Eleves Avec Stage</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table2">
                        <thead>
                        <tr class="ligne">
                            <th class="ligne">Etudiant</th>
                            <th class="ligne">Classe</th>
                            <th class="ligne" hidden>Entreprise</th>
                            <th class="ligne" hidden>Contact</th>
                            <th class="ligne" hidden>Telephone</th>
                            <th class="ligne" hidden>Mail</th>
                            <th>Recherches de Stages</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach(getEtudiantAvecStage() as $affiche){
                            $idEtudiant = $affiche['idetudiant'];
                            $nomEtudiant = $affiche['nom']." ".$affiche['prenom'];
                            $photoEtudiant = $affiche["photo"];
                            $classeEtudiant = $affiche["libelle_classe"];
                            //Début selection entreprise
                            $rqtEntreprise = "SELECT ent.nom AS nom, co.nom AS nomCo, co.prenom, co.tel, co.mail FROM sta_entreprise ent, sta_demande dem, sta_contact co WHERE ent.identreprise in (SELECT identreprise FROM `sta_contact` WHERE `idcontact` IN (SELECT `idcontact` FROM `sta_demande` WHERE idetat=4 AND idetudiant=$idEtudiant)) AND co.idcontact in (SELECT idcontact FROM `sta_demande` WHERE idetat=4 AND idetudiant=$idEtudiant);";
                            $resultEntreprise = $connection->query($rqtEntreprise);
                            $tableEntreprise = $resultEntreprise->fetchAll();
                            $nomEntreprise = null;
                            $nomContact = null;
                            $telContact = null;
                            $mailContact = null;

                            foreach($tableEntreprise as $afficheEntreprise){
                                if (sizeof($tableEntreprise) > 1){
                                    $nomEntreprise =$afficheEntreprise['nom']."; ".$nomEntreprise;
                                    $nomContact = $afficheEntreprise['prenom']." ".$afficheEntreprise['nomCo']."; ". $nomContact;
                                    $telContact = $afficheEntreprise['tel']."; ". $telContact;
                                    $mailContact = $afficheEntreprise['mail']."; ". $mailContact;
                                }else{
                                    $nomEntreprise = $afficheEntreprise['nom'];
                                    $nomContact = $afficheEntreprise['prenom']." ".$afficheEntreprise['nomCo'];
                                    $telContact = $afficheEntreprise['tel'];
                                    $mailContact = $afficheEntreprise['mail'];
                                }
                            }
                            //Fin selection entreprise
                            ?>
                            <tr class="ligne">

                                <?php echo "<td class='".$classeEtudiant."'>
                                    <a href='eleve.php?ideleve=".$idEtudiant."'>
                                        <img width='100' src='img/avatar/".$photoEtudiant."'>
                                    </a>".$nomEtudiant."
                                </td>
                                <td class='".$classeEtudiant."'>".$classeEtudiant."</td>
                                <td class='".$classeEtudiant."' hidden>".$nomEntreprise."</td>
                                
                                <td class='".$classeEtudiant."' hidden>".$nomContact."</td>
                                <td class='".$classeEtudiant."' hidden>".$telContact."</td>
                                <td class='".$classeEtudiant."' hidden>".$mailContact."'</td>

                                <td><a href='affichageDemandesEleve.php?ideleve=".$idEtudiant."' class='btn btn-primary'
                                       style='color: white'><i class='fas fa-address-card'></i></a></td>
                                ";
                                ?>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-between">
                    <div class="pl-3"></div>
                    <div class="mr-2">
                        <h4> <a data-toggle="modal" data-target="#modalExportToCsv" class="btn btn-primary" style="color: white">Télécharger</a></h4>
                    </div>
                </div>
            </div>
        </div>
        
     
</section>

<?php } ?>

<!-- Modal -->
<!-- DEBUT Fenêtre Popup export -->


<!-- on ajoute le nom du contact, son tel et son mail -->
<div class="modal fade" id="modalExportToCsv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Exporter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <label for="recipient-name" class="col-form-label">Classe:</label><br>
                        <select id="choixClasse" data-container="body" onchange="getValue();">
                            <?php foreach (getClasseSio() as $ligne) {
                                echo "<option value=" . $ligne[1] . ">" . $ligne[1] . "</option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="exportTableToCSV('elevesAvecStage.csv', 'table.table-striped.table2 tr.ligne', getValue())">Exporter</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN Fenêtre Popup export -->