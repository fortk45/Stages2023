<?php
session_start();
include 'inc.connexion.php';
$mail = htmlspecialchars($_REQUEST['mail']);
$prenom = htmlspecialchars($_REQUEST['prenom']);
$idetudiant = htmlspecialchars($_REQUEST['id']);
$token = $_SESSION['token'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
<script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js">
</script>
<script type="text/javascript">
   (function(){
      emailjs.init("kIGu8gq2qBiyyCov0");
   })();
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script>
var data = {
    service_id: 'service_58321ya',
    template_id: 'template_7argk8m',
    user_id: '2yTrfnVoIhhA9UUTk',
    template_params: {
        'email': '<?php echo $mail ?>',
        'prenom': '<?php echo $prenom ?>',
        'token': '<?php echo $token ?>',
        'g-recaptcha-response': '03AHJ_ASjnLA214KSNKFJAK12sfKASfehbmfd...'
    }
};
 
$.ajax('https://api.emailjs.com/api/v1.0/email/send', {
    type: 'POST',
    data: JSON.stringify(data),
    contentType: 'application/json'
    
})

<?php 
    $requete = $connection->prepare("INSERT INTO sta_reset(idetudiant,token) VALUES (:idetudiant, :token);");
    $requete->bindparam(':idetudiant', $idetudiant);
    $requete->bindparam(':token', $token);
    $requete->execute();
?>
 window.setTimeout(function() {
     window.location = 'login.php?reset_mail=1';
   }, 2000);

</script>
<script>



</script>

</body>
</html>


<?php 

    
    
    

?>


