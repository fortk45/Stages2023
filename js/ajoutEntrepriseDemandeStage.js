var requeteEntreprise;
function creerRequeteEntreprise()
{
    try
    {
        requeteEntreprise = new XMLHttpRequest();
    }
    catch (essaimicrosoft)
    {
        try
        {
            requeteEntreprise = new ActiveXObject("Msxm12.XMLHTTP");
        }
        catch (autremicrosoft)
        {
            try
            {
                requeteEntreprise = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (echec)
            {
                requeteEntreprise = null;
            }
        }
    }
    if (requeteEntreprise === null)
        alert ("impossible de créer l'objet requête");
}

function ajoutEntrepriseDemande(siretStore, nomEntrepriseStore, divisionNafStore, 
    telStore, mailStore, villeStore, cpStore){
    creerRequeteEntreprise();
    console.log(requeteEntreprise);

    //Ne pose pas de questions. Questionne ton choix d'études.
    var url = "data/ajoutEntrepriseDepuisDemande.php?siret2="+siretStore+"&nom2="+nomEntrepriseStore+"&naf2="+divisionNafStore+"&tel2="+telStore
        +"&mail2="+mailStore+"&ville2="+villeStore+"&cp2="+cpStore;
    console.log(url);
    requeteEntreprise.open("GET", url, true);
    requeteEntreprise.onreadystatechange = actualiserDropdownEntreprise;
    requeteEntreprise.send(null);
}

function actualiserDropdownEntreprise(){
    console.log(requeteEntreprise.responseText);
    document.getElementById("selectEnt").innerHTML=requeteEntreprise.responseText;
    document.getElementById("idEnt2").innerHTML=requeteEntreprise.responseText;

    $('#selectEnt').trigger('change');
 }
