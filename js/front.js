$(document).ready(function () {

    // ------------------------------------------------------- //
    // Custom Scrollbar
    // ------------------------------------------------------ //

    if ($(window).outerWidth() > 992) {
        $("nav.side-navbar").mCustomScrollbar({
            scrollInertia: 200
        });
    }

    // Main Template Color
    var brandPrimary = '#33b35a';

    // ------------------------------------------------------- //
    // Side Navbar Functionality
    // ------------------------------------------------------ //
    $('#toggle-btn').on('click', function (e) {

        e.preventDefault();

        if ($(window).outerWidth() > 1194) {
            $('nav.side-navbar').toggleClass('shrink');
            $('.page').toggleClass('active');
        } else {
            $('nav.side-navbar').toggleClass('show-sm');
            $('.page').toggleClass('active-sm');
        }
    });

    // ------------------------------------------------------- //
    // Tooltips init
    // ------------------------------------------------------ //    

    $('[data-toggle="tooltip"]').tooltip()

    // ------------------------------------------------------- //
    // Universal Form Validation
    // ------------------------------------------------------ //

    $('.form-validate').each(function() {  
        $(this).validate({
            errorElement: "div",
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            ignore: ':hidden:not(.summernote),.note-editable.card-block',
            errorPlacement: function (error, element) {
                // Add the `invalid-feedback` class to the error element
                error.addClass("invalid-feedback");
                //console.log(element);
                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element.siblings("label"));
                } 
                else {
                    error.insertAfter(element);
                }
            }
        });
    });
    // ------------------------------------------------------- //
    // Material Inputs
    // ------------------------------------------------------ //

    var materialInputs = $('input.input-material');

    // activate labels for prefilled values
    materialInputs.filter(function () {
        return $(this).val() !== "";
    }).siblings('.label-material').addClass('active');

    // move label on focus
    materialInputs.on('focus', function () {
        $(this).siblings('.label-material').addClass('active');
    });

    // remove/keep label on blur
    materialInputs.on('blur', function () {
        $(this).siblings('.label-material').removeClass('active');

        if ($(this).val() !== '') {
            $(this).siblings('.label-material').addClass('active');
        } else {
            $(this).siblings('.label-material').removeClass('active');
        }
    });

    // ------------------------------------------------------- //
    // Jquery Progress Circle
    // ------------------------------------------------------ //
    var progress_circle = $("#progress-circle").gmpc({
        color: brandPrimary,
        line_width: 5,
        percent: 80
    });
    progress_circle.gmpc('animate', 80, 3000);

    // ------------------------------------------------------- //
    // External links to new window
    // ------------------------------------------------------ //

    $('.external').on('click', function (e) {

        e.preventDefault();
        window.open($(this).attr("href"));
    });

    // ------------------------------------------------------ //
    // For demo purposes, can be deleted
    // ------------------------------------------------------ //

    var stylesheet = $('link#theme-stylesheet');
    $("<link id='new-stylesheet' rel='stylesheet'>").insertAfter(stylesheet);
    var alternateColour = $('link#new-stylesheet');

    if ($.cookie("theme_csspath")) {
        alternateColour.attr("href", $.cookie("theme_csspath"));
    }

    $("#colour").change(function () {

        if ($(this).val() !== '') {

            var theme_csspath = 'css/style.' + $(this).val() + '.css';

            alternateColour.attr("href", theme_csspath);

            $.cookie("theme_csspath", theme_csspath, {
                expires: 365,
                path: document.URL.substr(0, document.URL.lastIndexOf('/'))
            });

        }

        return false;
    });

});


    // ------------------------------------------------------ //
    // REGEX
    // ------------------------------------------------------ //


var test1, test2, test3, test4;
function test(){

    if (test1 && test2 && test3 && test4 ){
        document.getElementById('register').disabled = false;
        
    }
}

function sendEmail(){

    var templateParams = {
        to_name: document.getElementById('register-prenom').value="",
        mail: document.getElementById('register-mail').value=""
    };
    alert(to_name);
    alert(mail);
    
    emailjs.send('service_onwlddx', 'template_va2sy0k', templateParams) 
    
        .then(function(response) {
            alert("cc1");
           console.log('SUCCESS!', response.status, response.text);


        }, function(error) {
           console.log('FAILED...', error);
           alert("cc2");
        });
}

function verifNom() {
    var Nom = document.getElementById('register-nom').value;
    var regex = /^[a-zA-Z\-].{2,100}$/;
    if (Nom.match(regex)){
        //Mettre la 1ere lettre en maj
        Nom = document.getElementById('register-nom').style.color = 'green';
        var erreurNom = document.getElementById('erreurNom');
        erreurNom.innerHTML = "";
        test1 = true;
    }
    else 
    {
        Nom = document.getElementById('register-nom').style.color = 'red';
        var erreurNom = document.getElementById('erreurNom');
        erreurNom.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez au moins 3 lettres et uniquement des lettres !</font>";
        test1 = false;
    }
    test();
}


function verifPrenom() {
    var Prenom = document.getElementById('register-prenom').value;
    var regex = /^[a-zA-Z\-].{1,100}$/;
    if (Prenom.match(regex)){
        //Mettre la 1ere lettre en maj
        Prenom = document.getElementById('register-prenom').style.color = 'green';
        var erreurPrenom = document.getElementById('erreurPrenom');
        erreurPrenom.innerHTML = "";
        test2 = true;
    }
    else 
    {
        Prenom = document.getElementById('register-prenom').style.color = 'red';
        var erreurPrenom = document.getElementById('erreurPrenom');
        erreurPrenom.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez au moins 2 lettres et uniquement des lettres !</font>";
        test2 = false;
    }
    test();
}


function verifMail() {
    var Mail = document.getElementById('register-mail').value;
    var regex = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
    if (Mail.match(regex)){
        //Mettre la 1ere lettre en maj
        Mail = document.getElementById('register-mail').style.color = 'green';
        var erreurMail = document.getElementById('erreurMail');
        erreurMail.innerHTML = "";
        test3 = true;
    }
    else 
    {
        Mail = document.getElementById('register-mail').style.color = 'red';
        var erreurMail = document.getElementById('erreurMail');
        erreurMail.innerHTML = "<font color = red style=\"font-size:80%\"> Attention, rentrez une adresse mail valide ! Exemple : exemple@exemple.fr </font>";
        test3 = false;
    }
    test();
}

function verifMdp(){
    var password = document.getElementById('register-password').value;
    var regex = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{11,}$/;
    if (password.match(regex)){
        console.log("true");

        password = document.getElementById('register-password').style.color = 'green';
        var erreurPassword = document.getElementById('erreurPassword');
        erreurPassword.innerHTML = "";
        test4 = true;
    }
    else 
    {
        console.log("false");
        password = document.getElementById('register-password').style.color = 'red';
        var erreurPassword = document.getElementById('erreurPassword');
        erreurPassword.innerHTML = "<font color = red style=\"font-size:80%\"> Mot de passe invalide ! 12 caractères minimums (Majuscules, minuscules, chiffres et caractères spéciaux)</font>";
        test4= false;
    }
    test();
}