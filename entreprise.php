<?php 
include 'inc.header.php';
if(isset($_REQUEST["identreprise"]) && $_REQUEST["identreprise"]!="") {
    $identreprise = $_REQUEST["identreprise"];
    $sqlentreprise ="SELECT * FROM sta_entreprise e WHERE e.identreprise =".$identreprise; 
    $q = $connection->query($sqlentreprise);
    $affiche = $q->fetch();
    $identreprise = $affiche['identreprise'];
    $siret = $affiche['SIRET'];
    $nomEntreprise = $affiche['nom'];
    $nafEntreprise = $affiche['codeNAF'];
    $telEntreprise = $affiche['tel'];
    $emailEntreprise = $affiche['Mail'];
    $cpEntreprise = $affiche['cpville'];
    $villeEntreprise = $affiche['ville'];

    $sqlcontact ="SELECT DISTINCT * FROM sta_contact c WHERE identreprise =".$identreprise;
    $q2 = $connection->query($sqlcontact);
    $reponseEntrepriseContact = $q2->fetchAll();
}

if (isset($_REQUEST['updateEnt'])){
    $identreprise = $_REQUEST['identreprise'];
    $siret = $_REQUEST['SIRET'];
    $nomEntreprise = $_REQUEST['nomEntreprise'];
    $nafEntreprise = $_REQUEST['nafEntreprise'];
    $telEntreprise = $_REQUEST['telEntreprise'];
    $emailEntreprise = $_REQUEST['emailEntreprise'];
    $cpEntreprise = $_REQUEST['cpEntreprise'];
    $sqlupdateEntreprise = "UPDATE sta_entreprise SET SIRET ='$siret', nom = '$nomEntreprise', code_NAF ='$nafEntreprise', tel='$telEntreprise', mail='$emailEntreprise', cpville='$cpEntreprise' WHERE identreprise=".$identreprise;
    $connection->exec($sqlupdateEntreprise);

    echo '<div class="alert alert-success">'.$nomEntreprise.' a été modifiée.</div>';
}

if (isset($_REQUEST['updateContact'])){
    $idContact = $_REQUEST['idContact'];
    $nomContact = $_REQUEST['nomContact'];
    $prenomContact = $_REQUEST['prenomContact'];
    $telContact = $_REQUEST['telContact'];
    $mailContact = $_REQUEST['mailContact'];
    $roleContact = $_REQUEST['roleContact'];
    $serviceContact = $_REQUEST['serviceContact'];
    $sqlupdateContact = "UPDATE sta_contact SET  nom='$nomContact', prenom='$prenomContact', tel='$telContact', mail='$mailContact', role='$roleContact', service='$serviceContact' WHERE idcontact=".$idContact;
    $connection->exec($sqlupdateContact);

    echo '<div class="alert alert-success">Le contact '.$nomContact.' '.$prenomContact.' a été modifiée.</div>';
}
?>

<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item">Gestion entreprise </li>
            <li class="breadcrumb-item active"><?php echo $nomEntreprise;?> </li>
        </ul>
    </div>
</div>

<section>
    <div class="container-fluid">
        <header>
            <h1 class="h3 display"><?php echo $nomEntreprise;?> </h1>
        </header>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h4>Informations</h4>
                </div>
                <div class="card-body">
                    <?php
                    // Premet de modifier les informations de l'entreprise quand l'etat updateEnt passe en "Modifier" se qui se produit quand on clique sur le bouton modifier.
                        if (isset($_REQUEST["updateEnt"]) == "Modifier" ) {
                            $sqlModifInfoEntreprise = "UPDATE sta_entreprise set nom = :nomEntreprise, codeNAF = :nafEntreprise, tel = :telEntreprise, Mail = :emailEntreprise, cpville = :cpEntreprise, ville = :villeEntreprise where SIRET like '".$siret."'";
                            $modifInfoEntreprise = $connection->prepare($sqlModifInfoEntreprise);
                            $modifInfoEntreprise->bindParam(':nomEntreprise', $_REQUEST["nomEntreprise"], PDO::PARAM_STR);
                            $modifInfoEntreprise->bindParam(':nafEntreprise', $_REQUEST["nafEntreprise"], PDO::PARAM_STR);
                            $modifInfoEntreprise->bindParam(':telEntreprise', $_REQUEST["telEntreprise"], PDO::PARAM_STR);
                            $modifInfoEntreprise->bindParam(':emailEntreprise', $_REQUEST["emailEntreprise"], PDO::PARAM_STR);
                            $modifInfoEntreprise->bindParam(':cpEntreprise', $_REQUEST["cpEntreprise"], PDO::PARAM_STR);
                            $modifInfoEntreprise->bindParam(':villeEntreprise', $_REQUEST["villeEntreprise"], PDO::PARAM_STR);
                            $modifInfoEntreprise->execute();
                        }
                    ?>
                    <form class="form-horizontal" method="post">
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Siret</label>
                            <div class="col-sm-10">                              
                                <input type="text" class="form-control" name="SIRET" readonly 
                                    value="<?php echo $siret;?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Nom</label>
                            <div class="col-sm-10">
                                <input type="hidden" class="form-control" name="identreprise" 
                                    value="<?php echo $identreprise;?>">

                                <input type="text" class="form-control" id="nomEntreprise" name="nomEntreprise" onfocusout="verifFormEntreprise(), verifTest()" 
                                    value="<?php echo $nomEntreprise;?>">

                                    <div id ="erreurNomEntreprise" ></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Code NAF</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nafEntreprise" id="NAF" onfocusout="verifFormEntreprise()"
                                    value="<?php echo $nafEntreprise;?>">

                                    <div id ="erreurNAF" ></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Téléphone</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="telEntreprise" id="TelEntreprise" onfocusout="verifFormEntreprise()"
                                    value="<?php echo $telEntreprise;?>">
                                    <div id ="erreurTelEntreprise" ></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="emailEntreprise" id="MailEntreprise" onfocusout="verifFormEntreprise()"
                                    value="<?php echo $emailEntreprise;?>">
                                    <div id ="erreurMailEntreprise" ></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Code postal</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="cpEntreprise" id="CPEntreprise" onfocusout="verifFormEntreprise()"
                                    value="<?php echo $cpEntreprise;?>">
                                    <div id ="erreurCP" ></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 form-control-label">Ville</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="villeEntreprise" id="villeEntreprise" onfocusout="verifFormEntreprise()"
                                    value="<?php echo $villeEntreprise;?>">
                                    <div id ="erreurVille" ></div>
                            </div>
                        </div>
                        <?php if($userCheck == 'Admin'){ ?>
                        <div class="form-group">
                            <input type="submit" name="updateEnt" id="updateEnt" value="Modifier" class="btn btn-primary" disabled>
                        </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding">
    <div class="container-fluid">
        <div class="row d-flex align-items-center">
            <?php foreach ($reponseEntrepriseContact as $affiche) {
                    $idContact = $affiche['idcontact'];
                    $nomContact = $affiche['nom'];
                    $prenomContact = $affiche['prenom'];
                    $telContact = $affiche['tel'];
                    $mailContact = $affiche['mail'];
                    $roleContact = $affiche['role'];
                    $serviceContact = $affiche['service'];
                ?>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>Contact <?php echo $roleContact;?></h4>
                    </div>
                    <div class="card-body">
                    <?php
                    // Premet de modifier les informations de l'entreprise quand l'etat updateEnt passe en "Modifier" se qui se produit quand on clique sur le bouton modifier.
                        if (isset($_REQUEST["updateContact"]) == "Modifier" ) {
                            $sqlModifInfoContact = 'UPDATE sta_contact set idcontact = :idcontact, nom = :nomContact, prenom = :prenomContact, tel = :telContact,  mail = :mailContact, role = :roleContact, service = :serviceContact WHERE idcontact LIKE "'.$_REQUEST["idContact"].'" ';
                            $modifInfoContact = $connection-> prepare($sqlModifInfoContact);
                            $modifInfoContact->bindParam(':idcontact', $_REQUEST["idContact"], PDO::PARAM_STR);
                            $modifInfoContact->bindParam(':nomContact', $_REQUEST["nomContact"], PDO::PARAM_STR);
                            $modifInfoContact->bindParam(':prenomContact', $_REQUEST["prenomContact"], PDO::PARAM_STR);
                            $modifInfoContact->bindParam(':telContact', $_REQUEST["telContact"], PDO::PARAM_STR);
                            $modifInfoContact->bindParam(':mailContact', $_REQUEST["mailContact"], PDO::PARAM_STR);
                            $modifInfoContact->bindParam(':roleContact', $_REQUEST["roleContact"], PDO::PARAM_STR);
                            $modifInfoContact->bindParam(':serviceContact', $_REQUEST["serviceContact"], PDO::PARAM_STR);
                            $modifInfoContact->execute();
                        }
                    ?>
                        <form method="post">
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="hidden" class="form-control" name="idContact"
                                    value="<?php echo $idContact;?>">
                                <input type="text" class="form-control" id="nom" name="nomContact" onfocusout="verifFormContact()"
                                    value="<?php echo $nomContact;?>">
                                <div id ="erreurNom" ></div>
                            </div>
                            <div class="form-group">
                                <label>Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenomContact" onfocusout="verifFormContact()"
                                    value="<?php echo $prenomContact;?>">
                                    <div id ="erreurPrenom" ></div>
                            </div>
                            <div class="form-group">
                                <label>Téléphone</label>
                                <input type="text" name="telContact" id ="tel" class="form-control" onfocusout="verifFormContact()"
                                    value="<?php echo $telContact;?>">
                                    <div id ="erreurTel" ></div>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="mailContact" id="mail" class="form-control" onfocusout="verifFormContact()"
                                    value="<?php echo $mailContact;?>">
                                    <div id ="erreurMail" ></div>
                            </div>
                            <div class="form-group">
                                <label>Rôle</label>
                                <input type="text" name="roleContact" id="role" class="form-control" onfocusout="verifFormContact()"
                                    value="<?php echo $roleContact;?>">
                                    <div id ="erreurRole" ></div>

                            </div>
                            <div class="form-group">
                                <label>Service</label>
                                <input type="text" name="serviceContact" id ="service" class="form-control" onfocusout="verifFormContact()"
                                    value="<?php echo $serviceContact;?>">
                                    <div id ="erreurService" ></div>
                            </div>
                            <?php if($userCheck == 'Admin'){ ?>
                            <div class="form-group">
                                <input type="submit" name="updateContact" id="updateContact" value="Modifier" class="btn btn-primary" disabled>
                            </div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>
<script>
    function verifFormEntreprise(){
        
        var Nom = document.getElementById("nomEntreprise").value;
        var regexNom = /^[a-zA-Z0-9\séèêëàâùûîïôöç\'\"\«\»\.]{3,50}$/;
        if (Nom.match(regexNom)){
            erreurNomEntreprise.innerHTML= "";
            verifNom = true;
        }else{
            erreurNomEntreprise.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez un nom d'entreprise valide !</font>";
            verifNom = false;
        }

        var NAF = document.getElementById("NAF").value;
        var regexNAF = /^\d{2}\.\d{2}[A-Z]$/;
        if (NAF.match(regexNAF)){
            erreurNAF.innerHTML= "";
            verifNAF = true;
        }else{
            erreurNAF.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez un code NAF valide ! Exemple : 57.41U </font>";
            verifNAF = false;
        }

        var Tel = document.getElementById("TelEntreprise").value;
        var regexTel = /^((?:[1-9][0-9 ().-]{5,28}[0-9])|(?:(00|0)( ){0,1}[1-9][0-9 ().-]{3,26}[0-9])|(?:(\+)( ){0,1}[1-9][0-9 ().-]{4,27}[0-9]))$/;
        if (Tel.match(regexTel)){
            erreurTelEntreprise.innerHTML= "";
            verifTel = true;
        }else{
            erreurTelEntreprise.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez un numéro de téléphone valide !</font>";
            verifTel = false;
        }

        var Mail = document.getElementById("MailEntreprise").value;
        var regexMail = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
        if (Mail.match(regexMail)){
            erreurMailEntreprise.innerHTML= "";
            verifEmail = true;
        }else{
            erreurMailEntreprise.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez une adresse mail valide ! Exemple : exemple@exemple.fr</font>";
            verifEmail = false;
        }

        var CP = document.getElementById("CPEntreprise").value;
        var regexCP = /^\d{5}$/;
        if (CP.match(regexCP)){
            erreurCP.innerHTML= "";
            verifCP = true;
        }else{
            erreurCP.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez un code postale valide ! Exemple : 45000</font>";
            verifCP = false;
        }

        var Ville = document.getElementById("villeEntreprise").value;
        var regexVille = /^[a-zA-Z0-9\séèêëàâùûîïôöç\'\"\«\»]{3,50}$/;
        if (Ville.match(regexVille)){
            erreurVille.innerHTML= "";
            verifVille = true;
        }else{
            erreurVille.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez une ville valide !</font>";
            verifVille = false;
        }

        if (verifNom && verifNAF && verifTel && verifEmail && verifCP && verifVille) {
            document.getElementById('updateEnt').disabled = false;
        }else{
            document.getElementById('updateEnt').disabled = true;
        }
    }
    function verifFormContact(){

        var NomContact = document.getElementById("nom").value;
        var regexNomContact = /^[a-zA-Z]{3,50}$/;
        if (NomContact.match(regexNomContact)){
            erreurNom.innerHTML= "";
            verifNomContact = true;
        }else{
            erreurNom.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez au moins 3 lettres et uniquement des lettres !</font>";
            verifNomContact = false;
        }

        var Prenom = document.getElementById("prenom").value;
        var regexPrenom = /^[a-zA-Z]{3,50}$/;
        if (Prenom.match(regexPrenom)){
            erreurPrenom.innerHTML= "";
            verifPrenom = true;
        }else{
            erreurPrenom.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez au moins 3 lettres et uniquement des lettres !</font>";
            verifPrenom = false;
        }

        var TelContact = document.getElementById("tel").value;
        var regexTelContact = /^((?:[1-9][0-9 ().-]{5,28}[0-9])|(?:(00|0)( ){0,1}[1-9][0-9 ().-]{3,26}[0-9])|(?:(\+)( ){0,1}[1-9][0-9 ().-]{4,27}[0-9]))$/;
        if (TelContact.match(regexTelContact)){
            erreurTel.innerHTML= "";
            verifTelContact = true;
        }else{
            erreurTel.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez un numéro de téléphone valide !</font>";
            verifTelContact = false;
        }

        var MailContact = document.getElementById("mail").value;
        var regexMailContact = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
        if (MailContact.match(regexMailContact)){
            erreurMail.innerHTML= "";
            verifMailContact = true;
        }else{
            erreurMail.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez une adresse mail valide ! Exemple : exemple@exemple.fr</font>";
            verifMailContact = false;
        }

        var Role = document.getElementById("role").value;
        var regexRole = /^[a-zA-Z\séèêëàâùûîïôöç\'\"\«\»]{3,50}$/;
        if (Role.match(regexRole)){
            erreurRole.innerHTML= "";
            verifRole = true;
        }else{
            erreurRole.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez au moins 3 lettres et uniquement des lettres !</font>";
            verifRole = false;
        }

        var Service = document.getElementById("service").value;
        var regexService = /^[a-zA-Z0-9\séèêëàâùûîïôöç\'\"\«\»]{3,50}$/;
        if (Service.match(regexService)){
            erreurService.innerHTML= "";
            verifService = true;
        }else{
            erreurService.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez au moins 3 lettres !</font>";
            verifService = false;
        }

        if (verifNomContact && verifPrenom && verifTelContact && verifMailContact && verifRole && verifService) {
            document.getElementById('updateContact').disabled = false;
        }else{
            document.getElementById('updateContact').disabled = true;
        }
    }
</script>
<?php include 'inc.footer.php' ?>