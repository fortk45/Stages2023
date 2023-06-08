<?php 
include 'inc.header.php';


if (isset($_GET['suppEntreprise'])){
    $idEntreprise = $_GET['suppEntreprise'];
    $sqldelete = "DELETE FROM sta_entreprise WHERE identreprise=".$idEntreprise;
    $q = $connection->exec($sqldelete);

    echo '<div class="alert alert-danger" role="alert">L\'entreprise a été supprimée.</div>';
}

// REQUETE
if (isset($_REQUEST['searchEnt'])){
    switch ($_REQUEST['searchEnt']) {
        case 'nom':
            $rechercheEntreprise = $_POST['searchByName'];
            $sqlentreprise = "SELECT DISTINCT identreprise, nom, codeNAF, tel, Mail, cpville, ville
                                FROM sta_entreprise WHERE nom LIKE '%".$rechercheEntreprise."%'
                                ORDER BY nom asc";
            break;
        
        case 'cp':
            $rechercheCp = $_POST['searchByCp'];
            $sqlentreprise = "SELECT DISTINCT identreprise, nom, codeNAF, tel, Mail, cpville, ville
                                FROM sta_entreprise WHERE cpville = '".$rechercheCp."' 
                                ORDER BY nom asc";
            break;
        
        case 'naf':
            $rechercheNaf = $_POST['idNaf'];
            $sqlentreprise = "SELECT DISTINCT identreprise, nom, codeNAF, tel, Mail, cpville, ville
                                FROM sta_entreprise WHERE codeNAF = '".$rechercheNaf."'
                                ORDER BY nom asc";
            break;

        case 'demande':
            $sqlentreprise = "SELECT DISTINCT identreprise, nom, codeNAF, tel, Mail, cpville, ville
                                FROM sta_entreprise
                                WHERE identreprise IN (SELECT `identreprise` FROM `sta_contact` WHERE `idcontact` IN (SELECT `idcontact` FROM `sta_demande`)) 
                                ORDER BY nom asc";
            break;

        case 'stage':
            $sqlentreprise = "SELECT DISTINCT identreprise, nom, codeNAF, tel, Mail, cpville, ville
                                FROM sta_entreprise
                                WHERE identreprise IN (SELECT `identreprise` FROM `sta_contact` WHERE `idcontact` IN (SELECT `idcontact` FROM `sta_demande` WHERE `idetat`=4))                             
                                ORDER BY nom asc";
            break;

        default:
            $sqlentreprise = "SELECT DISTINCT identreprise, nom, codeNAF, tel, Mail, cpville, ville
                                FROM sta_entreprise
                                ORDER BY nom asc";
            break;
    }
} else {
    $sqlentreprise = "SELECT DISTINCT identreprise, nom, codeNAF, tel, Mail, cpville, ville
                        FROM sta_entreprise
                        ORDER BY nom asc";
}

$q = $connection->query($sqlentreprise);
$reponseEntreprises = $q->fetchAll();

?>

<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Gestion entreprises </li>
        </ul>
    </div>
</div>

<section class="">
    <div class="container-fluid">
        <header>
            <h1 class="h3 display">Gestion entreprises </h1>
        </header>
        <div class="card">
            <div class="card-body">
            <h4>Filtrer selon</h4>
                <form action="#" method="POST" class="inline-form">
                    <div class="form-group row">
                        <div class="col-4">
                            <input type="radio" id="nom" name="searchEnt" value="nom" onclick="changeSearchEnt(this)">
                            <label for="nom">Nom</label>
                        </div>

                        <div class="col-4">
                            <input type="radio" id="cp" name="searchEnt" value="cp" onclick="changeSearchEnt(this)">      
                            <label for="cp">Code postal</label>
                        </div>

                        <div class="col-4">
                            <input type="radio" id="naf" name="searchEnt" value="naf" onclick="changeSearchEnt(this)">
                            <label for="naf">Libellé NAF</label>
                        </div>

                        <div class="col-4">
                            <input type="radio" id="demande" name="searchEnt" value="demande" onclick="changeSearchEnt(this)"> 
                            <label for="demande">Demande de stage faite</label>
                        </div>

                        <div class="col-4">
                            <input type="radio" id="stage" name="searchEnt" value="stage" onclick="changeSearchEnt(this)">
                            <label for="stage">Stage trouvé</label>
                        </div>

                    </div>
                    <div id="filterEnt"></div>
                    <div class="form-group">
                        <input type="submit" value="Rechercher" class="mr-3 btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4>Entreprises</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Téléphone</th>
                                <th>Nom Contact</th>
                                <th>Email</th>
                                <th>CP</th>
                                <?php if($userCheck == 'Admin'){?>
                                <th>Supprimer</th>
                                <th>Modifier</th>
                                <th>Demandes</th>
                                <?php } ?>
                                <?php if($userCheck == 'Client'){?>
                                <th>Informations</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($reponseEntreprises as $affiche){
                                $idEntreprise = $affiche['identreprise'];                                
                                $nomEntreprise = $affiche["nom"]; 
                                $telEntreprise = $affiche["tel"]; 
                                $emailEntreprise = $affiche["Mail"]; 
                                $cpEntreprise = $affiche["cpville"]; 

                                if (isset($affiche['prenom'])){
                                    $nomContact = $affiche['prenom']." ".$affiche['c_nom'];
                                } else {
                                    //Récupérer la liste des contacts de l'entreprise
                                    $nomContact = "";
                                    $contactList = $connection->query("SELECT DISTINCT `prenom`, `nom` FROM `sta_contact` WHERE `identreprise`=$idEntreprise");
                                    $reponseContact = $contactList->fetchAll();
                                    foreach ($reponseContact as $unContact) {
                                        $nomContact .= "<li>".$unContact['prenom']." ".$unContact['nom']."</li>";
                                    }
                                }
                            ?>
                            <tr>
                                <td><?php echo $nomEntreprise;?></td>
                                <td><?php echo $telEntreprise;?></td>

                                <td>
                                    <?php 
                                    if (!empty($nomContact)){
                                        echo "<ul>".$nomContact."</ul>";
                                    }
                                    ?>
                                </td>

                                <td><?php echo $emailEntreprise;?></td>
                                <td><?php echo $cpEntreprise;?></td>
                                <?php if($userCheck == 'Admin'){?>
                                <td><a class="btn btn-danger" class="btn btn-primary" data-toggle="modal"
                                        data-target="#supp<?php echo $idEntreprise?>" style="color: white"><i
                                            class="fa fa-trash"></i></a></td>
                                <td><a href="entreprise.php?identreprise=<?php echo $idEntreprise; ?>"
                                        class="btn btn-primary" style="color: white"><i class="fa fa-edit"></i></a></td>
                                    <td><a href="affichageDemandesEntreprise.php?identreprise=<?php echo $idEntreprise; ?>"
                                           class="btn btn-primary" style="color: white"><i class="fas fa-list"></i></a></td>
                                <?php } ?>
                                <?php if($userCheck == 'Client'){?>
                                <td><a href="entreprise.php?identreprise=<?php echo $idEntreprise; ?>"
                                        class="btn btn-primary" style="color: white"><i class="fas fa-info"></i></a>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>

<!-- Modal -->
<?php foreach($reponseEntreprises as $affiche){
    $idEntreprise = $affiche['identreprise'];
    //$siret =  $affiche['SIRET'];
    $nomEntreprise = $affiche["nom"]; 
    $telEntreprise = $affiche["tel"]; 
    $emailEntreprise = $affiche["Mail"]; 
    $cpEntreprise = $affiche["cpville"]; 

?>
<div class="modal fade" id="supp<?php echo $idEntreprise?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Etes vous sur de vouloir supprimer <?php echo $nomEntreprise?> ?
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-secondary" style="color: white" data-dismiss="modal">Fermer</a>
                <a type="button" onclick="reloadPage()" class="btn btn-danger" style="color: white"
                    href="?suppEntreprise=<?php echo $idEntreprise?>">Supprimer</a>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php include 'inc.footer.php'; ?>