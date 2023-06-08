
function CurrentClass() {

    var currentClass = $( "#selectClasse option:selected" ).text()


    if (currentClass == "SIO2") {
        document.getElementById("selectPromotion").selectedIndex=1;

    }else{
        document.getElementById("selectPromotion").selectedIndex=0;

    }

}

