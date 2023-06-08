var requeteTuteur;
function creerRequeteTuteur()
{
    try
    {
        requeteTuteur = new XMLHttpRequest();
    }
    catch (essaimicrosoft)
    {
        try
        {
            requeteTuteur = new ActiveXObject("Msxm12.XMLHTTP");
        }
        catch (autremicrosoft)
        {
            try
            {
                requeteTuteur = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (echec)
            {
                requeteTuteur = null;
            }
        }
    }
    if (requeteTuteur === null)
        alert ("impossible de créer l'objet requête");
}

function ajoutTuteurDemande(nomContact2,prenomContact2,mailContact2,
    telContact2,roleContact2,serviceContact2,idEnt2){
    creerRequeteTuteur();
    console.log(requeteTuteur);

    // Roses are red
    // Violets are blue
    // I'm in front of your shed
    // And this code smells like poo .


    var urlTuteur = "data/ajoutTuteurDepuisDemande.php?nomContact2="+nomContact2+"&prenomContact2="+prenomContact2+"&maiLContact2="+mailContact2+"&telContact2="+telContact2
        +"&mailContact2="+mailContact2+"&roleContact2="+roleContact2+"&serviceContact2="+serviceContact2+"&idEnt2="+idEnt2;
    console.log(urlTuteur);
    requeteTuteur.open("GET", urlTuteur, true);
    requeteTuteur.onreadystatechange = actualiserDropdownTuteur;

    requeteTuteur.send(null);

    //Vide le dropdown tuteur


}

function actualiserDropdownTuteur(){
    //$("#selectTuteur").empty();
    console.log(requeteTuteur.responseText);
    document.getElementById("selectTuteur").innerHTML=requeteTuteur.responseText;
    //if(requeteTuteur.readyState==4){
    //$("#selectTuteur").appendText=requeteTuteur.responseText;
    //var newtext = document.createTextNode(requeteTuteur.responseText),
      //  p1 = document.getElementById("selectTuteur");

    //p1.appendChild(newtext);
        //var nouveauNoeud = document.createTextNode();

        //nouveauNoeud.wholeText=requeteTuteur.responseText;

        //console.log(nouveauNoeud);

    //}
    //var $idTuteur
}

