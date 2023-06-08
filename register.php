<?php 
include 'inc.connexion.php'; 
if (!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['email']) AND !empty($_POST['mdp']) AND !empty($_POST["option"]) AND !empty($_POST["promotion"]) AND !empty($_POST["classe"])){
    $nom = htmlentities($_POST["nom"]);
    $prenom = htmlentities($_POST["prenom"]);
    $classe = htmlentities($_POST["classe"]);
    $promotion  = htmlentities($_POST["promotion"]);
    $option  = htmlentities($_POST["option"]);
    $email = htmlentities($_POST["email"]);
    $mdp = htmlentities($_POST["mdp"]);
    $mdph = MD5($mdp);
//    $mdph = password_hash($mdp, PASSWORD_DEFAULT);


    $sql = "SELECT email FROM sta_etudiant";
    $q = $connection->query($sql);
    
    $emailDispo = true;
    while ($ligne = $q->fetch()) {

        
        if ($ligne[0]==$email) {
           $emailDispo = false;
        }
    }

    if ($emailDispo) {
        $sql = "INSERT INTO sta_etudiant(nom, prenom, idclasse, email, mdp, `option`,anneePro, photo) VALUES('".$nom."', '".$prenom."', '".$classe."', '".$email."', '".$mdph."','".$option."', '".$promotion."','membres.png')";
        $connection->exec($sql);
        session_start();
        $_SESSION['email']=$email;
        $_SESSION['name']=$prenom;
        $_SESSION['password']=$mdp;

        header ('Location: mailRegister.php');
    }else {
        echo "<div>L'email est déja utilisé</div>";
    }
     

    
}


?>
<!DOCTYPE html>
<html>

<?php 
    require "header.php";
?>

<body>

    <div class="page login-page">
    


        <div class="container">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <div class="form-inner">
                        <h1>

                            <?php 
                            include 'inc.connexion.php'; 
                            if (!empty($_REQUEST['nom']) AND !empty($_REQUEST['prenom']) AND !empty($_REQUEST['email']) AND !empty($_REQUEST['mdp']) AND !empty($_REQUEST["option"]) AND !empty($_REQUEST["promotion"]) AND !empty($_REQUEST["classe"]))
                            {
                                $nom = htmlentities($_REQUEST["nom"]);
                                $prenom = htmlentities($_REQUEST["prenom"]);
                                $classe = htmlentities($_REQUEST["classe"]);
                                $promotion  = htmlentities($_REQUEST["promotion"]);
                                $option  = htmlentities($_REQUEST["option"]);
                                $currentDate = date('Y-m-d');
                                $email = htmlentities($_REQUEST["email"]);
                                $mdp = htmlentities($_REQUEST["mdp"]);
                                $mdph = MD5($mdp);

                                try{
                                    $sql = "INSERT INTO sta_etudiant(nom, prenom, idclasse, email, mdp, `option`, dateCreationCompte, anneePro, photo) 
                                    VALUES(:nom, :prenom, :classe, :email, :mdp, :op,:currentDate, :promotion,'membres.png')";

                                    $sqlPrepare = $connection->prepare($sql);

                                    $sqlPrepare->bindParam(':nom',$nom);                                   
                                    $sqlPrepare->bindParam(':prenom',$prenom);                                  
                                    $sqlPrepare->bindParam(':classe',$classe);                                 
                                    $sqlPrepare->bindParam(':email', $email);                                   
                                    $sqlPrepare->bindParam(':mdp',$mdph);                                   
                                    $sqlPrepare->bindParam(':op',$option);
                                    $sqlPrepare->bindParam(':currentDate',$currentDate);
                                    $sqlPrepare->bindParam(':promotion',$promotion);
                            
                                    $sqlPrepare->execute();

                                    if ($sqlPrepare === false) {
                                        $err = $connection->errorInfo();
                                        if ($err[0] != '00000') {
                                            echo "Création impossible adresse email déjà utilisée !!!";
                                        }
                                    }
                                    else{
                                        session_start();
                                        $_SESSION['email']=$email;
                                        $_SESSION['name']=$prenom;
                                        $_SESSION['password']=$mdp;
                                        
                                        header ('Location: mailRegister.php');
                                    }
                                }
                                catch(Exception $e){
                                    echo"Création impossible adresse email déjà utilisée !!";
                                }

                                
                            }
                            
                            ?>
                            
                        </h1>
                        <div class="logo text-uppercase"><img src="img/logo.png">
                        </div>
                        <form method="get" action="register.php" class="text-left form-validate">
                            <div class="form-group-material">
                                <input id="register-nom" type="text" name="nom"  class="input-material" placeholder="Nom" onkeydown="verifNom()">
                                <div id ="erreurNom"></div>
                            </div>
                            <div class="form-group-material">
                                <input id="register-prenom" type="text" name="prenom"  class="input-material" placeholder="Prénom" onkeydown="verifPrenom()">
                                <div id ="erreurPrenom"></div>
                            </div>
                            <div class="form-group-material">
                                <input id="register-mail" type="text" name="email"  class="input-material" placeholder="Email" onkeyup="verifMail()">
                                <div id ="erreurMail"></div>
                            </div>
                            <div class="form-group-material">
                                <input id="register-password" type="password" name="mdp" 
                                    class="input-material" placeholder="Votre mot de passe" onkeydown="verifMdp()">
                                 <div id ="erreurPassword"></div>
                            </div>
                            <?php
                            global $currentClass;
                            $sql = "SELECT * FROM sta_classe WHERE idclasse < 3";
                            $q = $connection->query($sql);
                            echo "<div class='form-group'>";
                            echo "<label for='selectClasse'>Classe</label>";
                            echo "<select name='classe' onchange='CurrentClass();' class='form-control' id='selectClasse'>";                                            
                            while ($ligne = $q->fetch()) {

                                if ($row['libelle_classe'] == $ligne[0]){

                                    echo "<option value=" . $ligne[0] . " selected='selected'>" . $ligne[1] . "</option>";
                                    
                                    $currentClass = $ligne[1];
                                }
                                else{
                                    echo "<option value=" . $ligne[0] . ">" . $ligne[1] . "</option>";
                                    $currentClass = $ligne[1];
                                }
                            }
                            echo "</select>";
                            echo "</div>";
                        
                            echo "<div class='form-group'>";
                            echo "<label for='selectPromotion'>Promotion</label>";
                            echo "<select name='promotion' class='form-control' id='selectPromotion'>"; 
                            
                            for ($i=0; $i < 4 ; $i++) { 
                                    
                                echo "<option id=".$i." value=" . date("Y",strtotime("-$i year")) . ">" . date("Y",strtotime("-$i year")) . "</option>";
                            
                        
                            }
                            
                            echo "</select>";                                            
                            echo "</div>";
                        
        
                            ?>
                            <div class="form-group"><label for="selectOption">Option</label>
                                <select name="option" class="form-control is-valid" id="selectOption" aria-invalid="false">

                                    <option value="SLAM">SLAM</option>
                                    <option value="SISR">SISR</option>
                                    <option value="NON DETERMINEE">NON DETERMINÉE</option>
                                </select>
                            </div>
                            <div class="form-group text-center">
                                <button id="register" type="submit" class="btn btn-primary" disabled >S'inscrire</button>
                                <button type="reset" class="btn btn-primary">Annuler</button>
                            </div>
                        </form>
                        <small>Se connecter au site. </small>
                        <a href="login.php" class="signup">Connexion</a>
                    </div>
                </div>
                <div class="col-3"></div>
                
            </div>
        </div>
    </div>
    <!-- JavaScript files-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/grasp_mobile_progress_circle-1.0.0.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- Main File-->
    <script src="./js/front.js"></script>
    <script src="test.js"></script>
    

</body>

</html>