<?php 
include 'inc.header.php';

// suprimer demande stage
if (isset($_GET['suppDemande'])){
    $idDemande = $_GET['suppDemande'];
    $sqldelete = "DELETE FROM sta_demande WHERE iddemande=".$idDemande;
    $connection->exec($sqldelete);

    echo '<div class="alert alert-danger">La demande de stage a été supprimée.</div>';
}

// modifier demande stage 
if(isset($_REQUEST['idDemande']) && isset($_REQUEST['idetat'])){
    if(isset($_REQUEST['refusDem'])){
        $sql = "UPDATE sta_demande SET idetat='".$_REQUEST['idetat']."', raisonRefus='".$_REQUEST['refusDem']."' WHERE iddemande='".$_REQUEST['idDemande']."'";
    }else{
        $sql = "UPDATE sta_demande SET idetat='".$_REQUEST['idetat']."' WHERE iddemande='".$_REQUEST['idDemande']."'";
    }
    
    $connection->exec($sql);

}

if ($userCheck == 'Admin') {
?>

<section class="dashboard-counts section-padding">
    <div class="container-fluid">
        <div class="row">
            
            <!-- Count item widget-->
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="fas fa-user-graduate"></i></div>
                    <div class="name"><strong class="text-uppercase">SIO1</strong>
                        <div class="count-number"><?php echo getNbStagesSio1()."/".getNbElevesSio1();?></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-6">
                <div class="wrapper count-title d-flex">
                    <div class="icon"><i class="fas fa-user-graduate"></i></div>
                    <div class="name"><strong class="text-uppercase">SIO2</strong>
                        <div class="count-number"><?php echo getNbStagesSio2()."/".getNbElevesSio2();?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'affichageDemandes.php' ?>


<!-- Début Modale envoyer rappel -->
<?php 
$rqtEtudiant = "SELECT * FROM sta_etudiant";
$resultEtudiant = $connection->query($rqtEtudiant);
$tableEtudiant = $resultEtudiant->fetchAll();
foreach($tableEtudiant as $affiche){
    $idEtudiant = $affiche['idetudiant'];
    $nomEtudiant = $affiche['nom']." ".$affiche['prenom'];
    $mailEtudiant = $affiche['email'];
?>
<div class="modal fade" id="rappel<?php echo $idEtudiant?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Envoyer un rappel à <?php echo $nomEtudiant?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="mailRappel.php" method="post">
                    <div class="form-group">
                        <label for="dateDem" class="col-form-label">Mail :</label>
                        <input type="text" class="form-control" value="<?php echo $mailEtudiant?>" name="mailEtudiant"
                            id="dateDem">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Message :</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="message" rows="3" placeholder="entrer votre message"></textarea>
                    </div>
                    <input type="submit" value="Ajouter" class="btn btn-primary">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- Fin Modale envoyer rappel -->

<?php } ?>

<?php
if ($userCheck == 'Client') {
    // Ajout contact
    // Affichage du message au retour de la création tuteur
    if(isset($_SESSION['ajoutTuteurOk'])){
        echo "<div class='alert alert-success'>Le tuteur ".$_SESSION['nomTuteur']." à bien été crée.</div>";
        //On enlève les variable de session passée depuis ajoutDemande.php, afin que le message disparaisse au rafraichissement.
        unset($_SESSION['ajoutTuteurOk']);
        unset($_SESSION['nomTuteur']);
    }
    // Ajout demande de stage
    //Affichage du message au retour de l'ajout de la demande de stage
    if(isset($_SESSION['ajoutDemandeOk'])){
        echo "<div class='alert alert-success'>Nouvelle demande de stage ajoutée.</div>";
        //On enlève la variable de session passée depuis ajoutDemande.php, afin que le message disparaisse au rafraichissement.
        unset($_SESSION['ajoutDemandeOk']);
    }
    // Affichage du message au retour de la création d'entreprise
    if(isset($_SESSION['ajoutEntOk'])){
        echo "<div class='alert alert-success'>L' entreprise ".$_SESSION['nomEnt']." à bien été crée.</div>";
        //On enlève les variable de session passée depuis ajoutDemande.php, afin que le message disparaisse au rafraichissement.
        unset($_SESSION['ajoutEntOk']);
        unset($_SESSION['nomEnt']);
    }
    // Modifier ETAT ET RAISON d'une demande de stage
    if(isset($_REQUEST['raison']) && isset($_REQUEST['idetat']) && isset($_REQUEST['iddemande'])){
        
        
    }
?>

<br>
<section class="">
    <div class="container-fluid">
        <div class="card-header">
            <h4>Historique des recherches
                <a data-toggle="modal" data-target="#ajoutDemande" class="btn btn-primary" style="color: white"><i
                        class="fas fa-plus"></i> Nouvelle demande de stage</a>
                <a data-toggle="modal" data-target="#ajoutEntreprise" class="btn btn-primary" style="color: white"><i
                        class="fas fa-plus"></i> Nouvelle entreprise</a>
                <a data-toggle="modal" data-target="#ajoutContact" class="btn btn-primary" style="color: white"><i
                        class="fas fa-plus"></i> Nouveau tuteur</a>
            </h4>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Entreprise</th>
                                <th>Date demande</th>
                                <th>Etat</th>
                                <th>Raison refus</th>
                                <th>Période</th>
                                <th>Supprimer</th>
                                <th>Modifier</th>
                            </tr>
                        </thead>
                        <!--Affichage des recherches de stage-->
                        <tbody>
                            <?php
                            foreach(getHistoriqueStage() as $affiche){
                                $idDemande = $affiche['iddemande'];
                                $nomEntreprise = $affiche["nom"]; 
                                $dateDemande = $affiche["date_demande"];
                                $periodeStage = $affiche["date_debut"]." au ".$affiche["date_fin"];
                                $etatStage = $affiche["libelle_etat"];
                                if($etatStage!='Refusé'){
                                    $raisonRefus = '';
                                }else{
                                    $raisonRefus = $affiche["raisonRefus"];
                                }
                            ?>
                           
                            <tr>
                                <td><?php echo $nomEntreprise;?></td>
                                <td><?php echo $dateDemande;?></td>
                                <td><?php echo $etatStage;?></td>
                                <td><?php echo $raisonRefus;?></td>
                                <td><?php echo $periodeStage;?></td>
                                <td>
                                    <a class="btn btn-danger" class="btn btn-primary" data-toggle="modal"
                                        data-target="#supp<?php echo $idDemande?>" style="color: white">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-success" class="btn btn-primary" data-toggle="modal"
                                       data-target="#update<?php echo $idDemande?>" style="color: white">
                                       <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


<!--Ajout d'un formulaire d'ajout de demande de stage-->

<div class="modal fade" id="ajoutDemande" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter une demande de stage</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="ajoutDemande.php">
                    <div class="form-group">
                        <label for="dateDem" class="col-form-label">Date de la demande:</label>
                        <input required type="date" class="form-control" name="dateDem" id="dateDem">
                    </div>
                    <div class="form-group">
                        <label for="selectPeriode">Période de stage</label>
                        <br>
                        <select name='idperiode' class="form-control" id="selectPeriode">
                            <?php foreach(getFuturPeriode() as $ligne) {
                                echo "<option value=" . $ligne[0] . ">" . $ligne[1] ." au ".$ligne[2]. "</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="selectEnt">Entreprise</label>
                        <br>
                        <select name='idEnt' class="form-control" id="selectEnt">
                            <option disabled selected value="">--Choisir une entreprise--
                                <?php foreach (getEntreprise() as $ligne) {
                                echo "<option value=" . $ligne[0] . ">" . $ligne[1] . "</option>";
                            } ?>
                        </select>
                            <a data-toggle="modal" data-target="#ajoutEntrepriseDepuisStage" class="btn btn-primary" style="color: white"><i
                        class="fas fa-plus"></i>Ajouter une nouvelle entreprise</a>
                    </div>
                    <div class="form-group" id="tuteurAjax">
                    </div>
                    <div class="form-group">
                        <label for="selectEtat">État</label>
                        <br>
                        <select required name='idetat' class="form-control" id="selectEtat">
                            <?php foreach (getEtat() as $ligne) {
                                echo "<option value=" . $ligne[0] . ">" . $ligne[1] . "</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="form-group" id="refusAjax">

                    </div>
                    <input type="submit" value="Ajouter" class="btn btn-primary">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

    <!--Ajout d'un formulaire d'ajout de tuteur-->

<div class="modal fade" id="ajoutContact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un tuteur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="ajoutTuteur.php">
                    <div class="form-group">
                        <label for="nomContact" class="col-form-label">Nom:</label>
                        <input required type="text" class="form-control" name="nomContact" id="nomContact">
                    </div>
                    <div class="form-group">
                        <label for="prenomContact" class="col-form-label">Prénom:</label>
                        <input required type="text" class="form-control" name="prenomContact" id="prenomContact">
                    </div>
                    <div class="form-group">
                        <label for="mailContact" class="col-form-label">Mail:</label>
                        <input type="email" class="form-control" name="mailContact" id="mailContact">
                    </div>
                    <div class="form-group">
                        <label for="telContact" class="col-form-label">Tel:</label>
                        <input type="text" class="form-control" name="telContact" id="telContact" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label for="selectEnt">Entreprise</label>
                        <br>
                        <select name='idEnt' class="form-control" id="selectEnt">
                            <option disabled selected value="">--Choisir une entreprise--
                                <?php foreach (getEntreprise() as $ligne) {
                                echo "<option value=" . $ligne[0] . ">" . $ligne[1] . "</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="roleContact" class="col-form-label">Role:</label>
                        <input type="text" class="form-control" name="roleContact" id="roleContact">
                    </div>
                    <div class="form-group">
                        <label for="serviceContact" class="col-form-label">Service:</label>
                        <input type="text" class="form-control" name="serviceContact" id="serviceContact">
                    </div>
                    <input type="submit" value="Ajouter" class="btn btn-primary">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

    <!--Ajout d'un formulaire d'ajout d'entreprise-->

<div class="modal fade" id="ajoutEntreprise" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter une entreprise</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <a href="https://www.manageo.fr/" target="_blank">Trouver le SIRET et le code NAF de
                        l'entreprise</a>
                    <a href="https://blog.easyfichiers.com/wp-content/uploads/2014/08/Liste-code-naf-ape.pdf"
                        target="_blank">Trouver la
                        division NAF de l'entreprise</a>
                    <a href="https://public.opendatasoft.com/explore/dataset/correspondance-code-insee-code-postal/table/"
                        target="_blank">Trouver le code postal unique</a>
                </div>
                <form method="post" action="ajoutEntreprise.php">
                    <div class="form-group">
                        <label for="siretEnt" class="col-form-label">SIRET :</label>
                        <input type="number" class="form-control" name="siretEnt" id="siretEnt">
                    </div>
                    <div class="form-group">
                        <label for="nomEnt" class="col-form-label">Nom :</label>
                        <input required type="text" class="form-control" name="nomEnt" id="nomEnt">
                    </div>

                    <div class="form-group">
                        <label for="selectNaf">Division NAF</label>
                        <br>
                        <select required name='nafEnt' class="form-control" id="nafEnt">
                            <option disabled selected value="">--Choisir une division NAF--
                                <?php foreach (getNaf() as $ligne) {
                                echo  "<option value=" . $ligne[0] . ">" . $ligne[1] . "</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="telEnt" class="col-form-label">Tel :</label>
                        <input type="text" class="form-control" name="telEnt" id="telEnt" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label for="mailEnt" class="col-form-label">Mail :</label>
                        <input type="text" class="form-control" name="mailEnt" id="mailEnt">
                    </div>
                    <div class="form-group">
                        <label for="villeEnt" class="col-form-label">Ville :</label>
                        <input type="text" class="form-control" name="villeEnt" id="villeEnt">
                    </div>
                    <div class="form-group">
                        <label for="cpEnt" class="col-form-label">Code Postal :</label>
                        <input type="number" class="form-control" name="cpEnt" id="cpEnt">
                    </div>
                    <input type="submit" value="Ajouter" class="btn btn-primary">
                </form>
                <script src="js/cpApi.js"></script>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!--Formulaire d'ajout d'entreprise depuis la demande de stage-->

<div class="modal fade" id="ajoutEntrepriseDepuisStage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter une entreprise</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <a href="https://www.manageo.fr/" target="_blank">Trouver le SIRET et le code NAF de
                        l'entreprise</a>
                    <a href="https://blog.easyfichiers.com/wp-content/uploads/2014/08/Liste-code-naf-ape.pdf"
                        target="_blank">Trouver la
                        division NAF de l'entreprise</a>
                    <a href="https://public.opendatasoft.com/explore/dataset/correspondance-code-insee-code-postal/table/"
                        target="_blank">Trouver le code postal unique</a>
                </div>
                <form method="post">
                    <div class="form-group">
                        <label for="siretEnt2" class="col-form-label">SIRET :</label>
                        <input type="number" class="form-control" name="siretEnt2" id="siretEnt2">
                    </div>
                    <div class="form-group">
                        <label for="nomEnt2" class="col-form-label">Nom :</label>
                        <input required type="text" class="form-control" name="nomEnt2" id="nomEnt2">
                    </div>

                    <div class="form-group">
                        <label for="selectNaf2">Division NAF</label>
                        <br>
                        <select required name='nafEnt2' class="form-control" id="nafEnt2">
                            <option disabled selected value="">--Choisir une division NAF--
                                <?php foreach (getNaf() as $ligne) {
                                    echo  "<option value=" . $ligne[0] . ">" . $ligne[1] . "</option>";
                                } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="telEnt2" class="col-form-label">Tel :</label>
                        <input type="text" class="form-control" name="telEnt2" id="telEnt2" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label for="mailEnt2" class="col-form-label">Mail :</label>
                        <input type="text" class="form-control" name="mailEnt2" id="mailEnt2">
                    </div>
                    <div class="form-group">
                        <label for="villeEnt2" class="col-form-label">Ville :</label>
                        <input type="text" class="form-control" name="villeEnt2" id="villeEnt2" >
                    </div>
                    <div class="form-group">
                        <label for="cpEnt2" class="col-form-label">Code Postal :</label>
                        <input type="number" class="form-control" name="cpEnt2" id="cpEnt2">
                    </div>
                    <script src="js/ajoutEntrepriseDemandeStage.js"></script>
                    <button type="button" value="Ajouter" class="btn btn-primary" onclick="ajoutEntrepriseDemande(siretEnt2.value,nomEnt2.value,nafEnt2.value,
                    telEnt2.value,mailEnt2.value,villeEnt2.value,cpEnt2.value)" data-dismiss="modal">Ajouter</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!--Formulaire d'ajout du tuteur depuis le formulaire d'ajout de demande de stage-->

<div class="modal fade" id="ajoutTuteurDepuisStage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajouter un tuteur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="nomContact2" class="col-form-label">Nom:</label>
                        <input required type="text" class="form-control" name="nomContact2" id="nomContact2">
                    </div>
                    <div class="form-group">
                        <label for="prenomContact2" class="col-form-label">Prénom:</label>
                        <input required type="text" class="form-control" name="prenomContact2" id="prenomContact2">
                    </div>
                    <div class="form-group">
                        <label for="mailContact2" class="col-form-label">Mail:</label>
                        <input type="email" class="form-control" name="mailContact2" id="mailContact2">
                    </div>
                    <div class="form-group">
                        <label for="telContact2" class="col-form-label">Tel:</label>
                        <input type="text" class="form-control" name="telContact2" id="telContact2" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label for="selectEnt2">Entreprise</label>
                        <br>
                        <select name='idEnt2' class="form-control" id="idEnt2">
                            <option disabled selected value="">--Choisir une entreprise--
                                <?php foreach (getEntreprise() as $ligne) {
                                    echo "<option value=" . $ligne[0] . ">" . $ligne[1] . "</option>";
                                } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="roleContact2" class="col-form-label">Role:</label>
                        <input type="text" class="form-control" name="roleContact2" id="roleContact2">
                    </div>
                    <div class="form-group">
                        <label for="serviceContact" class="col-form-label">Service:</label>
                        <input type="text" class="form-control" name="serviceContact2" id="serviceContact2">
                    </div>
                    <script src="js/ajoutTuteurDemandeStage.js"></script>
                    <button type="button" value="Ajouter" class="btn btn-primary" onclick="ajoutTuteurDemande(nomContact2.value,prenomContact2.value,mailContact2.value,
                    telContact2.value,roleContact2.value,serviceContact2.value,idEnt2.value)" data-dismiss="modal">Ajouter</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
<?php } 

foreach(getDemandeStage() as $affiche){
    $idDemande = $affiche['iddemande'];
?>
<div class="modal fade" id="supp<?php echo $idDemande?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Etes vous sur de vouloir supprimer cette demande de stage ?
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-secondary" style="color: white" data-dismiss="modal">Fermer</a>
                <a type="button" class="btn btn-danger" style="color: white"
                    href="?suppDemande=<?php echo $idDemande?>">Supprimer</a>
            </div>
        </div>
    </div>
</div>
    
<div class="modal fade" id="update<?php echo $idDemande?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier la demande de stage</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">                 
                    <div class="form-group" id="tuteurAjax<?php echo $idDemande?>">
                    </div>
                    <div class="form-group">
                        <label for="selectEtat<?php echo $idDemande?>">Etat</label>
                        <br>
                        <select required name='idetat' class="form-control" id="selectEtat<?php echo $idDemande?>" onchange="afficheRefus(<?php echo $idDemande?>)">
                            <?php foreach (getEtat() as $ligne) {
                                echo "<option value=" . $ligne[0]. ">" . $ligne[1] . "</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="form-group" id="refusAjax<?php echo $idDemande?>">

                    </div>
                    <input type="hidden" value="<?php echo $idDemande?>" name="idDemande"> 
                    <input type="submit" value="Modifier" class="btn btn-primary">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>



<?php } ?>

<?php include 'inc.footer.php' ?>