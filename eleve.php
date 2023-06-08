<?php 

session_start();

//VERIFICATION DE L'ETUDIANT
if (isset($_SESSION['code'])){
    if(isset($_GET["ideleve"]) && $_GET["ideleve"]!="") {
        if ($_SESSION['idclasse'] == 3) {
            $idEtudiant = $_GET["ideleve"];
            $_SESSION['updateEtudiant'] = $idEtudiant;
        } else {
            //on vérifie si l'id entré dans l'URL correspond à l'ID de l'étudiant
            if ($_SESSION['code'] != $_GET["ideleve"]){
                //si l'utilisateur n'est pas admin
                //étudiant X est étudiant X, point barre.
                $idEtudiant = $_SESSION['code'];
                header("Location: eleve.php?ideleve=$idEtudiant");
            } else {
                $idEtudiant = $_SESSION['code'];
            }
        }
    } else {
        //si y a pas le get renseigné, on redirige vers le profil de l'étudiant
        $idEtudiant = $_SESSION['code'];
        header("Location: eleve.php?ideleve=$idEtudiant");
    }
} else {
    header("Location: index.php");
}


include 'inc.header.php';
if(isset($_GET["ideleve"]) && $_GET["ideleve"]!="") {

    $sqleleve ="SELECT * FROM sta_etudiant e, sta_classe c WHERE c.idclasse=e.idclasse AND e.idetudiant = :idEtudiant";
    $q = $connection->prepare($sqleleve);
    $q->bindParam(':idEtudiant', $idEtudiant);
    $q->execute();
    $affiche = $q->fetch();

    $idEtudiant = $affiche['idetudiant'];
    $nomEtudiant = $affiche['nom'];
    $prenomEtudiant = $affiche['prenom'];
    $photoEtudiant = $affiche['photo'];
    $emailEtudiant = $affiche['email'];
    $classeEtudiant = $affiche['libelle_classe'];
    $promotionEtudiant = $affiche['anneePro'];
    $attestStage = $affiche['attestStage'];
    $convention = $affiche['convention'];
    $eval = $affiche['eval'];

    $sqlhistorique = "SELECT * FROM sta_etudiant e, sta_demande d, sta_periode p, sta_contact c, sta_entreprise en 
                        WHERE c.identreprise=en.identreprise AND c.idcontact=d.idcontact AND d.idperiode=p.idperiode 
                        AND e.idetudiant=d.idetudiant AND d.idetat=4 AND e.idetudiant=:idEtudiant ORDER BY p.date_debut asc";
    $q20 = $connection->prepare($sqlhistorique);
    $q20->bindParam(':idEtudiant', $idEtudiant);
    $q20->execute();
    $reponse20 = $q20->fetchAll();
} else {
    //header('Location: gestionEleves.php');
}

?>

<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item">Gestion étudiant </li>
            <li class="breadcrumb-item active"><?php echo $nomEtudiant." ".$prenomEtudiant;?> </li>
        </ul>
    </div>
</div>

<section class="">
    <div class="container-fluid">
        <header>
            <h1 class="h3 display"><?php echo $nomEtudiant." ".$prenomEtudiant;?> </h1>
        </header>
        <!-- Contenu -->
        <section class="section-padding">
            <div class="container-fluid">
                <div class="card data-usage">
                    <div class="row d-flex align-items-center">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center justify-content-center">
                                <img class="rounded-circle" height="200" width="200"
                                    src="img/avatar/<?php echo $photoEtudiant;?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <span>Email: <?php echo $emailEtudiant;?></span><br>
                            <span>Classe: <?php echo $classeEtudiant;?></span><br>
                            <span>Promotion: <?php echo $promotionEtudiant;?></span><br>
                            <a class="btn btn-primary" data-toggle="modal"
                                        data-target="#modifProfil" style="color: white">Modifier</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="">
            <div class="container-fluid">
                <div class="card-header">
                    <h4>Historique des stages</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Période</th>
                                        <th>Entreprise</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach($reponse20 as $affiche){
                                    $periode = $affiche["date_debut"]." au ".$affiche['date_fin']; 
                                    $nomEntreprise = $affiche["nom"];
                                    ?>
                                    <tr>
                                        <td><?php echo $periode;?></td>
                                        <td><?php echo $nomEntreprise;?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </section>

        <section class="statistics">
            <div class="container-fluid">
                <div class="row d-flex">
                    <div class="col-lg-4">
                        <!-- Attestation-->
                        <div class="card income text-center">
                            <div class="icon"><i class="fas fa-scroll"></i>
                                <p>Attestation</p>
                            </div>
                            <?php //if($attestStage!="") { ?>
                            
                            
                            <?php //} else { ?>
                                <form id="attestation" id="form2" action="uploadAttestStage.php" method="POST" enctype="multipart/form-data">
                                    <p id="attest">Upload l'attestation de stage signée: </p>
                                    <input type="hidden" value="<?php echo $nomEtudiant; ?>" name="nom">
                                    <input type="hidden" value="<?php echo $idEtudiant; ?>" name="idEtu">
                                    <input type="file" name="attestStage" multiple="multiple" onchange="document.getElementById('attestation').submit();">
                                </form>
                            <br><br>

                            <!--<form id="form2" action="supAttest.php" method="POST">-->
							<form id="form2" action="supAttest" method="POST">
                                
                                <input type="hidden" value="<?php echo $nomEtudiant; ?>" name="nom">
                                <input type="hidden" value="<?php echo $idEtudiant; ?>" name="idEtu">
                                <input type="submit" class="btn btn-danger" value="Supprimer" name="submit">
                                
                            </form>
                            <br>
                            <?php
                                foreach (glob("justificatifs/attestation/".$idEtudiant."_".$nomEtudiant."_"."*") as $filename) {
                                    echo "<a  class='btn btn-primary'  href='".$filename."' download>".basename($filename)."</a>" ;
                                }
                                /*if (file_exists('img/attestation/')){
                                    $dir = 'img/attestation/';
                                    $a = scandir($dir);
                                    for ($i=2; $i < count($a); $i++) { 
                                        
                                        echo "<a  class='btn btn-primary'  href='".$dir.$a[$i]."' download>".$a[$i]."</a>" ;
                                    }
                                }*/
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Convention -->
                        <div class="card income text-center">
                            <div class="icon"><i class="fas fa-handshake"></i>
                                <p>Convention</p>
                            </div>                           
                            <form id="conv" id="form2" action="uploadConventionStage.php" method="post" enctype="multipart/form-data">
                                <p id="attest">Upload la convention de stage signée: </p>
                                <input type="hidden" value="<?php echo $nomEtudiant; ?>" name="nom">
                                <input type="hidden" value="<?php echo $idEtudiant; ?>" name="idEtu">
                                <input type="file" name="convention" onchange="document.getElementById('conv').submit();" multiple="multiple"><br />
                            </form>
                            <br><br>
                            <form id="form2" action="supConvention" method="POST">   
                        <!--<form id="form2" action="supConvention.php" method="POST">-->								
                                <input type="hidden" value="<?php echo $nomEtudiant; ?>" name="nom">
                                <input type="hidden" value="<?php echo $idEtudiant; ?>" name="idEtu">
                                <input type="submit" class="btn btn-danger" value="Supprimer" name="submit">                                
                            </form>  
                            <br>                          
                            <?php
                                foreach (glob("justificatifs/convention/".$idEtudiant."_".$nomEtudiant."_"."*") as $filename) {
                                    echo "<a  class='btn btn-primary'  href='".$filename."' download>".basename($filename)."</a>" ;
                                }
                            /*
                            if (file_exists('img/accord/')){
                                $dir = 'img/accord/';
                                $a = scandir($dir);
                                for ($i=2; $i < count($a); $i++) { 
                                    echo "<a  class='btn btn-primary'  href='".$dir.$a[$i]."' download>".$a[$i]."</a>" ;
                                }
                            }*/
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Evaluation -->
                        <div class="card income text-center">
                            <div class="icon"><i class="fa fa-graduation-cap"></i>
                                <p>Evaluation</p>
                            </div>                       
                            <form id="eval" id="form2" action="uploadEvalStage.php" method="post" enctype="multipart/form-data">
                                <p id="attest">Upload l'évaluation de stage : </p>
                                <input type="hidden" value="<?php echo $nomEtudiant; ?>" name="nom">
                                <input type="hidden" value="<?php echo $idEtudiant; ?>" name="idEtu">
                                <input type="file" name="eval" onchange="document.getElementById('eval').submit();" multiple="multiple"><br />
                            </form>
                            <br>
                            <br>
                            <form id="form2" action="supEval" method="POST"> 
                            <!--<form id="form2" action="supEval.php" method="POST">-->							
                                <input type="hidden" value="<?php echo $nomEtudiant; ?>" name="nom">
                                <input type="hidden" value="<?php echo $idEtudiant; ?>" name="idEtu">
                                <input type="submit" class="btn btn-danger" value="Supprimer" name="submit">                                
                            </form>
                            <br>
                            <?php
                                foreach (glob("justificatifs/eval/".$idEtudiant."_".$nomEtudiant."_"."*") as $filename) {
                                    echo "<a  class='btn btn-primary'  href='".$filename."' download>".basename($filename)."</a>" ;
                                }
                            /*if (file_exists('img/eval/')){
                                $dir = 'img/eval/';                                
                                $a = scandir($dir);  
                                for ($i=2; $i < count($a); $i++) {                                     
                                    echo "<a  class='btn btn-primary'  href='".$dir.$a[$i]."' download>".$a[$i]."</a><br>" ;
                                }
                            }*/                       
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </section>
</section>

<!-- Modal -->
<?php 
$rqtEtudiant = "SELECT * FROM sta_etudiant WHERE idetudiant=".$idEtudiant;
$resultEtudiant = $connection->query($rqtEtudiant);
$tableEtudiant = $resultEtudiant->fetchAll();
foreach ($tableEtudiant as $infoEtudiant){
    $nomEtud = $infoEtudiant['nom'];
    $prenomEtud = $infoEtudiant['prenom'];
    $mailEtud = $infoEtudiant['email'];
    $idClasseEtud = $infoEtudiant['idclasse'];
?>
<div class="modal fade" id="modifProfil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier informations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="data/updateEtudiant.php" class="form-validate" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="dateDem" class="col-form-label">Nom:</label>
                        <input type="text" class="form-control" value="<?php echo $nomEtud?>" name="updateNomEtudiant" id="updateNomEtudiant">
                    </div>
                    <div class="form-group">
                        <label for="dateDem" class="col-form-label">Prenom:</label>
                        <input type="text" class="form-control" value="<?php echo $prenomEtud?>" name="updatePreomEtudiant" id="updateNomEtudiant">
                    </div>
                    <div class="form-group">
                        <label for="dateDem" class="col-form-label">Mail:</label>
                        <input type="text" class="form-control" value="<?php echo $mailEtud?>" name="updateMailEtudiant" id="updateNomEtudiant">
                    </div>
                    <div class="form-group">
                        <label>Classe: </label>
                        <?php 
                        $rqtClasse = "SELECT * FROM sta_classe WHERE idclasse NOT IN (3,4)";
                        $resultClasse = $connection->query($rqtClasse);
                        foreach ($resultClasse as $table) {
                            $idClasse = $table['idclasse'];
                            $libelleClasse = $table['libelle_classe'];
                        ?>
                        <input type="radio" name="updateClasseEtudiant" id="optionsRadios<?php echo $idClasse ?>"
                            value="<?php echo $idClasse ?>"
                            <?php if($idClasse==$idClasseEtud) { echo "checked=''"; }?>>
                        <label for="optionsRadios<?php echo $idClasse ?>"><?php echo $libelleClasse ?></label>
                        <?php } ?>
                    </div>                    
                    <div class="form-group">
                        <label for="dateDem" class="col-form-label">Mot de passe:</label>
                        <input type="text" class="form-control" name="updateMdpEtudiant" id="updateNomEtudiant">
                    </div>
                    <label>Image de profil</label>
                    <div class="custom-file form-group">
                        <input type="file" name="updateImageEtudiant" class="custom-file-input" id="fileUpload" >
                        <label class="custom-file-label" for="fileUpload">Choose file</label>
                    </div>
                    <input type="submit" value="Valider" class="btn btn-primary">
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

<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
