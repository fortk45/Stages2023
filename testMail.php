
<?php 

echo "<script>


$('#myForm').on('submit', function(event) {
    event.preventDefault();
    
    var formData = new FormData(this);
    formData.append('service_id', 'service_p27nkhf');
    formData.append('template_id', 'template_5zae2un');
    formData.append('user_id', 'kIGu8gq2qBiyyCov0');
 
    $.ajax('https://api.emailjs.com/api/v1.0/email/send-form', {
        type: 'POST',
        data: formData,
        contentType: false, 
        processData: false 
    }).done(function() {
        alert('Your mail is sent!');
    }).fail(function(error) {
        alert('Oops... ' + JSON.stringify(error));
    });
});


</script>";
?>