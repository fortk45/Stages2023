const apiVilleURL = 'https://geo.api.gouv.fr/communes?nom=';
const format ='&fields=codesPostaux&format=json&geometry=centre';

function affiche(){
    ville = document.getElementById("villeEnt").value;
    let url = apiVilleURL + ville + format;
    var select = document.getElementById("cpEnt");

    fetch(url, {method: 'get'}).then(response => response.json()).then(results => {
        if(results.length){
            while (select.firstChild){
                select.removeChild(select.firstChild);
            }
            $.each(results, function(key, value){
                i = 0;
                for (i in value.codesPostaux) {
                    var newOption = new Option (value.codesPostaux[i]);
                    select.options.add (newOption);
                    i++;
                }

            });
        }

});
}
function affiche2(){
    ville = document.getElementById("villeEnt2").value;

    let url = apiVilleURL + ville + format;
    var select = document.getElementById("cpEnt2");


    fetch(url, {method: 'get'}).then(response => response.json()).then(results => {
        if(results.length){
            while (select.firstChild){
                select.removeChild(select.firstChild);
            }
            $.each(results, function(key, value){
                i = 0;
                for (i in value.codesPostaux) {
                    var newOption = new Option (value.codesPostaux[i]);
                    select.options.add (newOption);
                    i++;
                }

            });
        }

    });
}