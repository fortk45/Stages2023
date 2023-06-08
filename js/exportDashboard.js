function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob(["\uFEFF"+csv], {type: "text/csv; charset=utf-8"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}

function exportTableToCSV(filename, ligne, classe) {
    var csv = [];
    var rows = document.querySelectorAll(ligne);
    console.log(classe);
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td."+classe+", th.ligne");
        if (cols.length!==0){
            for (var j = 0; j < cols.length; j++) {
                row.push(cols[j].innerText);
            }
            csv.push(row.join(";"));
        }
    }

    // Download CSV file
    downloadCSV(csv.join("\n"), filename);
}

function getValue(){
    var valueClasse = document.getElementById("choixClasse");
    var selectedValue = valueClasse.options[valueClasse.selectedIndex].value;
    return selectedValue;
}