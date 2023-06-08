if (window.location.href.match('gestionPeriodes.php') != null) {
    window.onload = actualiserPage();
  }

function creerRequetePeriode()
{
    try
    {
        requetePeriode = new XMLHttpRequest();
    } 
    catch (essaimicrosoft)
    {
        try
        {
            requetePeriode = new ActiveXObject("Msxm12.XMLHTTP");
        } 
        catch (autremicrosoft)
        {
            try
            {
                requetePeriode = new ActiveXObject("Microsoft.XMLHTTP");
            } 
            catch (echec)
            {
                requetePeriode = null;
            }
        }
    }
    if (requetePeriode === null)
    alert ("impossible de créer l'objet requête");
}

function ajoutPeriode(debutPeriode, finPeriode, promoPeriode){
    creerRequetePeriode();
    var url = "data/ajoutPeriode.php?debutPeriode="+debutPeriode+"&finPeriode="+finPeriode+"&promoPeriode="+promoPeriode;
    requetePeriode.open("GET", url, true);
    requetePeriode.onreadystatechange = actualiserPage;
    requetePeriode.send(null);
}

function modifPeriode(idPeriode, debutPeriode, finPeriode, promoPeriode){
    creerRequetePeriode();
    var url = "data/modifPeriode.php?idPeriode="+idPeriode+"&debutPeriode="+debutPeriode+"&finPeriode="+finPeriode+"&promoPeriode="+promoPeriode;
    requetePeriode.open("GET", url, true);
    requetePeriode.onreadystatechange = actualiserPage;
    requetePeriode.send(null);
}

function ajoutPromotion(libellePromotion){
    creerRequetePeriode();
    var url = "data/ajoutPromotion.php?libelle_promotion="+libellePromotion;
    requetePeriode.onreadystatechange = document.location.reload();
    requetePeriode.open("GET", url, true);
    requetePeriode.send(null);
}

function suppressionPeriode(idPeriode){
    creerRequetePeriode();
    var url = "data/suppressionPeriode.php?idPeriode="+idPeriode;
    requetePeriode.open("GET", url, true);
    requetePeriode.onreadystatechange = actualiserPage;
    requetePeriode.send(null);
}
function suppressionPromo(idPromo){
    creerRequetePeriode();
    var url = "data/suppressionPromo.php?idPeriode="+idPromo;
    requetePeriode.open("GET", url, true);
    requetePeriode.send(null);
}

function actualiserPage(){
    creerRequetePeriode();
    var url = "data/actualiserListeGestionPeriode.php";
    requetePeriode.open("GET", url, true);
    requetePeriode.onreadystatechange = afficherListeGestionPeriode;
    requetePeriode.send(null);
}

function afficherListeGestionPromo(){
    if (requetePeriode.readyState === 4){
        document.getElementById("tbodyPeriode").innerHTML = requetePeriode.responseText;
        actualiserModaleSuppr();
    }
}

function afficherListeGestionPeriode(){
    if (requetePeriode.readyState === 4){
        document.getElementById("tbodyPeriode").innerHTML = requetePeriode.responseText;
        actualiserModaleSuppr();
    }
}

function actualiserModaleSuppr(){
    creerRequetePeriode();
    var url = "data/afficheModaleSuppr.php";
    requetePeriode.open("GET", url, true);
    requetePeriode.onreadystatechange = afficherModaleSuppr;
    requetePeriode.send(null);
}

function afficherModaleSuppr(){
    if (requetePeriode.readyState === 4){
        document.getElementById("modaleSuppr").innerHTML = requetePeriode.responseText;
    }
}