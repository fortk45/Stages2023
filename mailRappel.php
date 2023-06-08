<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoi du rappel en cours</title>
</head>
<body>
    <?php require 'verifAdmin.php'; ?>
Votre rappel s'envoie ! ^^

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
    service_id: 'service_p27nkhf',
    template_id: 'template_rm3ja9c',
    user_id: 'kIGu8gq2qBiyyCov0',
    template_params: {
        'mail': '<?php echo $_POST["mailEtudiant"] ?>',
        'message': '<?php echo $_POST["message"] ?>',
        'g-recaptcha-response': '03AHJ_ASjnLA214KSNKFJAK12sfKASfehbmfd...'
    }
};
 
$.ajax('https://api.emailjs.com/api/v1.0/email/send', {
    type: 'POST',
    data: JSON.stringify(data),
    contentType: 'application/json'
    
})
window.setTimeout(function() {
    window.location = 'index.php';
  }, 1000);
</script>

</body>
</html>