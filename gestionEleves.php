<?php 

session_start();

if ($_SESSION['idclasse'] != 3) {
    header("Location: eleve.php?ideleve=$idEtudiant");
}

include 'inc.header.php';

// REQUETE
// if (isset($_REQUEST['rechercheEleve'])&& $_REQUEST['rechercheEleve']!="") {
//     $rechercheEleve = $_POST['rechercheEleve'];
//     $sqleleve = "SELECT DISTINCT * FROM sta_etudiant e, sta_classe c WHERE c.idclasse=e.idclasse AND e.idclasse not in (3,4) AND e.nom LIKE '%".$rechercheEleve."%'";
// } else {
//     $sqleleve = "SELECT DISTINCT * FROM sta_etudiant e, sta_classe c WHERE c.idclasse=e.idclasse AND e.idclasse not in (3,4) ORDER BY e.nom asc";
// }

// $q = $connection->query($sqleleve);
// $reponseEleves = $q->fetchAll();

if (isset($_REQUEST["check"])) {
    foreach($_REQUEST["check"] as $val){
        $sql =('UPDATE sta_etudiant SET idclasse = 4 WHERE ' .$val. ' = idetudiant');
        $q = $connection->prepare($sql);
        $q->execute(array($val));
    }
    echo '<div class="alert alert-success">'.sizeof($_REQUEST["check"]).' étudiant passé en anciens élèves.</div>';
}

if (isset($_GET['suppEleve'])){
    $idEleve = $_GET['suppEleve'];

    $demandesDelete = "DELETE FROM sta_demande WHERE idetudiant=".$idEleve;
    $q01 = $connection->exec($demandesDelete);

    $demandesDelete = "DELETE FROM sta_ticket WHERE id_etudiant=".$idEleve;
    $q02 = $connection->exec($demandesDelete);

    $sqldelete = "DELETE FROM sta_etudiant WHERE idetudiant=".$idEleve;
    $q = $connection->exec($sqldelete);

    echo '<div class="alert alert-danger" role="alert">
    L\'etudiant a été supprimé.
  </div>';
}


/*Filtre affichage des élèves selon : 
    - $_REQUEST["RechercheSLAM"] : option SLAM
    - $_REQUEST["RechercheSISR"] : option SISR
    - $_REQUEST["RechercheStage"] : avec un stage
    - $_REQUEST["RechercheSstage"] : sans stage


$_REQUEST['FiltrerS'] est le bouton de filtre 

*/

$color=false;

function currentChoice(){

    

    $query = "SELECT * FROM sta_etudiant, sta_classe, sta_periode WHERE sta_periode.idclasse = sta_classe.idclasse AND sta_classe.idclasse=sta_etudiant.idclasse AND sta_etudiant.idclasse not in (3,4)";
    
    


    if(isset($_REQUEST["rechercheEleve"])){
        $rechercheEleve = $_REQUEST["rechercheEleve"];

    }else{
        $rechercheEleve = "";
        $query = "SELECT * FROM sta_etudiant, sta_classe, sta_periode WHERE sta_periode.idclasse = sta_classe.idclasse AND sta_classe.idclasse=sta_etudiant.idclasse AND sta_etudiant.idclasse not in (3,4)";
        
    }

    if (($rechercheEleve !="") && $_REQUEST['rechercheEleve']!="") {
            
        $query .= 'AND sta_etudiant.nom LIKE "%'.$rechercheEleve.'%"';

    }

    if (!empty($_REQUEST["RechercheSISR"]) && empty($_REQUEST["RechercheSLAM"])) {
        $query .= " AND `option`=\"SISR\" ";
    }
    else if (!empty($_REQUEST["RechercheSLAM"]) && empty($_REQUEST["RechercheSISR"])) {
        $query .= " AND `option`=\"SLAM\" ";
    }
    else if (!empty($_REQUEST["RechercheSLAM"]) && !empty($_REQUEST["RechercheSISR"])) {
        $query .= " AND `option` in ('SISR','SLAM');";
    }

    if (!empty($_REQUEST["RechercheStage"])) {
        $query .= " AND `convention`=1";
    }
    else if (!empty($_REQUEST["RechercheSstage"])) {
        $query .= " AND `convention`=0";
    }

    $query .= " GROUP BY sta_etudiant.idetudiant";
    return $query;
}

$afficheEleve="";

function execute($currentQuery, $bdd){


    $q = $bdd->query($currentQuery);
    $afficheEleve = $q->fetchAll(); 
    return $afficheEleve;
print($afficheEleve);
    
}




?>

<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active">Gestion étudiants </li>
        </ul>
    </div>
</div>

<section class="">
    <div class="container-fluid">
        <header>
            <h1 class="h3 display">Gestion élèves </h1>
        </header>
        <div class="card">
            <div class="card-body">
                <form action="" method="POST" class="form-inline">
                    <div class="form-group">
                        
                    </div>

                </form>
                <br>
                <br>
                <!--
                    Filtre à effectuer par : 
                        - la promotion
                        - l'option
                        - avec ou sans stage
                -->
                
                <form action="" method="POST">
                    <div class="form-group">
                    <label for="rechercheEtu" class="sr-only">Rechercher par nom</label>
                        <input id="rechercheEtu" type="text" name="rechercheEleve" placeholder="Rechercher par nom" class="mr-3 form-control">
                        <div class="row">

                            <div class="col-2">
                                <div>
                                    <p>
                                        <input unchecked type="checkbox" class="checkStage" name="RechercheSLAM" id="SLAM">
                                        <label for="SLAM">Option SLAM</label>
                                    </p> 
                                </div>
                            </div>

                            <div class="col-2">
                                <div>
                                    <p>
                                        <input type="checkbox" class="checkStage" name="RechercheSISR" id="SISR">
                                        <label for="SISR">Option SISR</label>
                                    </p> 
                                </div>
                            </div>

                            <div class="col-2">
                                <div>
                                    <p>
                                        <input type="checkbox" class="checkStage" name="RechercheStage" id="stage">
                                        <label for="stage">Avec stage</label>
                                    </p> 
                                </div>
                            </div>
                            
                            <div class="col-2">
                                <div>
                                    <p>
                                        <input type="checkbox" class="checkStage" name="RechercheSstage" id="Sstage">
                                        <label for="Sstage">Sans stage</label>
                                    </p> 
                                </div>
                            </div>

                            <div class="col-2">
                                <div>
                                    <input type="submit" value="Filtrer" name="FiltrerS" class="mr-3 btn btn-primary">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        
                    </div>
                </form>


            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4>Eleves</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <form action="" method="POST">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Email</th>
                                <th>Classe</th>
                                <th>Début du stage</th>
                                <th>Fin du stage</th>
                                <th>Supprimer</th>
                                <th>Informations</th>
                                <th><input type="submit" value="Passage anciens élèves" class="btn btn-primary" style="color: white"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 

                            $sqlPeriode = 'SELECT DATE_FORMAT(sta_periode.date_debut, "%d/%m/%Y") AS "Début du stage", DATE_FORMAT(sta_periode.date_fin, "%d/%m/%Y") AS "Fin du stage" FROM sta_classe, sta_periode WHERE sta_periode.idperiode = sta_classe.idclasse ;' ;

    
                            

                            foreach(execute(currentChoice(), $connection) as $unEleve){

                                $idEleve = $unEleve['idetudiant'];
                                $nomEleve = $unEleve["nom"]; 
                                $prenomEleve = $unEleve["prenom"]; 
                                $emailEleve = $unEleve["email"]; 
                                $classeEleve = $unEleve["libelle_classe"]; 
                                $periode = $unEleve["date_debut"];
                                $periode2 = $unEleve["date_fin"];

                            ?>
                            <tr style="background-color: <?php 
                            
                                if($unEleve['convention'] == '1'){
                                    echo "rgba(56,180,92, 0.5)";
                                }
                                
                            
                            
                            
                            ?>;">
                                <td><?php echo $nomEleve;?></td>
                                <td><?php echo $prenomEleve;?></td>
                                <td><?php echo $emailEleve;?></td>
                                <td><?php echo $classeEleve;?></td>
                                <td><?php echo $periode;?></td>
                                <td><?php echo $periode2;?></td>
                                <td><a class="btn btn-danger" class="btn btn-primary" data-toggle="modal"
                                        data-target="#supp<?php echo $idEleve?>" style="color: white"><i
                                            class="fa fa-trash"></i></a></td>
                                <td><a href="eleve.php?ideleve=<?php echo $idEleve; ?>" class="btn btn-primary"
                                        style="color: white"><i class="fa fa-edit"></i></a></td>
                                <td>
                                    <div class="i-checks">
                                        <input id="checkboxCustom<?php echo $idEleve?>" name="check[]" type="checkbox"
                                            value="<?php echo $idEleve?>" class="form-control-custom">
                                        <label for="checkboxCustom<?php echo $idEleve?>"></label>
                                    </div>
                                </td>

                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>
        </div>
</section>



<?php 
    foreach(execute(currentChoice(), $connection) as $unEleve){
    $idEleve = $unEleve['idetudiant'];
    $nomEleve = $unEleve["nom"]; 
    $prenomEleve = $unEleve["prenom"]; 
    $emailEleve = $unEleve["email"]; 
    $classeEleve = $unEleve["idclasse"];
?>
<div class="modal fade" id="supp<?php echo $idEleve?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Etes vous sur de vouloir supprimer <?php echo $nomEleve." ".$prenomEleve?> ?
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-secondary" style="color: white" data-dismiss="modal">Fermer</a>
                <a type="button" class="btn btn-danger" style="color: white"
                    href="?suppEleve=<?php echo $idEleve?>">Supprimer</a>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<?php include 'inc.footer.php' ?>

<script>
    $('#rechercheEtu').autocomplete({
        source: 'data/jsonNomEtudiant.php'
    });
</script>
