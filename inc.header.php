<?php
//if (session_status() == PHP_SESSION_NONE) { //Evite une erreur dans le cas ou la session est deja existante
//    session_start(); // Si session status = none alors start() sinon continue
//}
if (!isset($_SESSION)) { session_start(); }    
include "inc.connexion.php";
include "inc.function.php";
$userCheck="";
if ($_SESSION['idclasse'] == 3) {
    //$sql = "select * from sta_promotion";
    //$table = $connection ->query($sql);    
    $date = date("d-m-Y");

    $daterentree = "01-09-".date("Y");
    if($date >= $daterentree){
        $_SESSION['popup'] = true;       
    } 
/*
    while($row = $table->fetch()) {
        if($row['libelle_promotion'] == date("Y")+1){
            unset($_SESSION['popup']);
        }
    }
    */
    $userCheck = 'Admin';
} else if($_SESSION['idclasse'] == 2 || $_SESSION['idclasse'] == 1) {
    $userCheck = 'Client';
} else {
    header("Location: login.php");
}

$sqlphoto = "SELECT photo FROM sta_etudiant WHERE idetudiant = " . $_SESSION['code'];
$q1 = $connection->query($sqlphoto);
$ligne = $q1->fetch();

$sqlticket = "SELECT *,count(id_ticket) as nbticket FROM sta_ticket t, sta_etudiant e WHERE t.id_etudiant=e.idetudiant AND statut = 'En attente' ORDER BY t.date_ticket asc";
$q2 = $connection->query($sqlticket);
$reponse = $q2->fetchAll();

$sqlnbticket = "SELECT count(id_ticket) as nbticket FROM sta_ticket t WHERE statut = 'En attente'";
$q3 = $connection->query($sqlnbticket);
$reponse3 = $q3->fetch();
$nbticket = $reponse3['nbticket'];

if(isset($_REQUEST['messageTicket'])){
    $msgTicket = $_REQUEST['messageTicket'];
    $todayDate = date("Y/m/d");
    $idEtudiant = $_SESSION['code'];

    $sqlTicket = "INSERT INTO sta_ticket( id_etudiant, motif_ticket, date_ticket) VALUES ('$idEtudiant',:msgTicket,'$todayDate')";
    $qTicket = $connection->prepare($sqlTicket);
    $qTicket->bindParam(':msgTicket', $msgTicket);
    $qTicket->execute();
}

?>
<!DOCTYPE html>
<html>

<?php 
    require "header.php";
?>

<body>
    <!-- Side Navbar -->
    <nav class="side-navbar">
        <div class="side-navbar-wrapper">
            <!-- Sidebar Header    -->
            <div class="sidenav-header d-flex align-items-center justify-content-center">
                <!-- User Info-->
                <div class="sidenav-header-inner text-center"><img src="img/avatar/<?php echo $ligne['photo']?>"
                        alt="person" class="img-fluid rounded-circle">
                    <h2 class="h5"><?php echo $_SESSION['nom']." ".$_SESSION['prenom'] ?></h2>
                    <span><?php echo $_SESSION['nomClasse']?></span>
                </div>
                <!-- Small Brand information, appears on minimized sidebar-->
                <div class="sidenav-header-logo">
                    <a href="index.php" class="brand-small text-center">
                        <strong>RS</strong>
                    </a>
                </div>
            </div>
            <!-- Sidebar Navigation Menus-->
            <?php
            if ($userCheck == 'Admin') {
            ?>
            <div class="main-menu">
                <h5 class="sidenav-heading">Main</h5>
                <ul id="side-main-menu" class="side-menu list-unstyled">
                    <li><a href="index.php"> <i class="fas fa-home"></i>DASHBOARD </a></li>
                    <li><a href="gestionEleves.php"> <i class="fas fa-user-graduate"></i>GESTION ELEVES </a></li>
                    <li><a href="gestionEntreprises.php"> <i class="fas fa-building"></i>GESTION ENTREPRISES </a></li>
                    <li><a href="gestionPeriodes.php"> <i class="fas fa-calendar-alt"></i>GESTION PERIODES <br/>DE STAGE </a></li>
                    <li><a href="gestionTicket.php"> <i class="fas fa-envelope">
                            <?php 
                                if ($nbticket !=0){
                                    echo"<span class='badge badge-info'> $nbticket </span>";
                                }?>
                            </i>GESTION DES TICKETS</a></li>                    
                </ul>
            </div>
            <?php } else if ($userCheck == "Client") {?>
            <div class="etud-menu">
                <h5 class="sidenav-heading">Etudiant</h5>
                <ul id="side-admin-menu" class="side-menu list-unstyled">
                    <li> <a href="index.php"> <i class="fas fa-home"></i>DASHBOARD</a></li>
                    <li> <a href="eleve.php?ideleve=<?php echo $_SESSION['code']?>"> <i
                                class="fas fa-user"></i>PROFIL</a></li>
                    <li> <a href="gestionEntreprises.php"> <i class="fas fa-search"></i>RECHERCHE</a></li>
                </ul>
            </div>
            <?php } ?>
        </div>
    </nav>
    <div class="page">
        <!-- navbar-->
        <header class="header">
            <nav class="navbar">
                <div class="container-fluid">
                    <div class="navbar-holder d-flex align-items-center justify-content-between">
                        <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars">
                                </i></a><a href="index.php" class="navbar-brand">
                                <div class="brand-text d-none d-md-inline-block"><img width="100" src="img/logo.png">
                                </div>
                            </a></div>
                        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                            <!-- Notifications dropdown-->
                            <?php
                            if ($userCheck == 'Admin') {
                            ?>
                            <li class="nav-item dropdown"> <a id="messages" rel="nofollow" data-target="#" href="#"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    class="nav-link"><i class="fa fa-envelope"></i>
                                    <?php 
                                        if ($nbticket !=0){
                                            echo"<span class='badge badge-info'> $nbticket </span>";
                                        }
                                    ?></a>
                                <ul aria-labelledby="notifications" class="dropdown-menu">
                                    <?php 
                                    if ($nbticket!=0){
                                    foreach ($reponse as $affiche) {
                                        $nomEtudiant = $affiche['nom']." ".$affiche['prenom'];
                                        $photoEtudiant = $affiche['photo'];
                                        $motifTicket = $affiche['motif_ticket'];
                                        $dateTicket = date_create($affiche['date_ticket']);
                                    ?>
                                    <li><a rel="nofollow" href="#" class="dropdown-item d-flex">
                                            <div class="msg-profile"> <img src="img/avatar<?php echo $photoEtudiant?>"
                                                    alt="..." class="img-fluid rounded-circle"></div>
                                            <div class="msg-body">
                                                <h3 class="h5"><?php echo $nomEtudiant?></h3>
                                                <span><?php echo $motifTicket?></span><small><?php echo date_format($dateTicket, 'l j F Y');?></small>
                                            </div>
                                        </a>
                                    </li>
                                    <?php }} ?>
                                    <li><a rel="nofollow" href="gestionTicket.php"
                                            class="dropdown-item all-notifications text-center">
                                            <strong> <i class="fa fa-envelope"></i>Gestion des tickets </strong></a>
                                    </li>
                                </ul>
                            </li>
                            <?php }

                            if ($userCheck == 'Client') {
                            ?>
                            <li class="nav-item dropdown"> <a id="ticket" data-target="#modalTicket" href="#"
                                    data-toggle="modal" aria-haspopup="true" aria-expanded="false" class="nav-link"><i
                                        class="fa fa-ticket"></i></a>
                            </li>
                            <?php } ?>
                            <!-- Log out-->
                            <li class="nav-item"><a href="deconnect.php" class="nav-link logout"> <span
                                        class="d-none d-sm-inline-block">Déconnexion</span><i
                                        class="fa fa-sign-out"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <?php 
        if(isset($_SESSION['popup'])){
            echo "<nav class='navbar navbar-light bg-warning'> /!\ Veuillez créer la promotion, les périodes de stage et archiver les anciens étudiants ".date("Y")." /!\</nav>";
        }
        
        ?>

        <div class="modal fade" id="modalTicket" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Envoyer un ticket</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                            <div class="form-group">
                                <label for="messageTicket" class="col-form-label">Message:</label>
                                <textarea id="messageTicket" class="form-control" name="messageTicket"></textarea>
                            </div>
                            <input type="submit" value="Envoyer" class="btn btn-primary">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>