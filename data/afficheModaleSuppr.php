<?php

include '../inc.connexion.php';

$sqlperiode = "SELECT DISTINCT * FROM sta_periode ORDER BY date_debut desc";
$q = $connection->query($sqlperiode);
$reponse = $q->fetchAll();

$sqlLesClasses = "SELECT * FROM `sta_classe` WHERE idclasse=1 OR idclasse=2 ";
$rechercheClasses = $connection->query($sqlLesClasses);
$ligneClasses = $rechercheClasses->fetchAll();

 foreach($reponse as $affiche){
        $idPeriode = $affiche['idperiode'];
        $dateDebut1 = $affiche['date_debut'];
        $dateFin1 = $affiche['date_fin'];
        $classe = $affiche['idclasse'];
    
  echo '<div class="modal fade" id="modif'.$idPeriode.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modifier la période de stage</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form method="get">
            <div class="form-group">
            <label for="recipient-name" class="col-form-label">Date début:</label>
            <input type="date" class="form-control" name="dateDebut" id="recipient-name" value="'.$dateDebut1.'">
            </div>
            <div class="form-group">
            <label for="recipient-name" class="col-form-label">Date fin:</label>
            <input type="date" class="form-control" name="dateFin" id="recipient-name" value="'.$dateFin1.'">
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Classe:</label><br>
                <select id="choixClasse" data-container="body">';
                foreach ($ligneClasses as $ligne) {
                    echo "<option value=" . $ligne[0]; 
                    if ($ligne[0] == $classe){
                        echo " selected";
                    }
                    echo ">" . $ligne[1] . "</option>";
                }
            echo '</select>
            </div>
            <input type="button" value="Modifier" class="btn btn-primary" onclick="modifPeriode('.$idPeriode.', dateDebut.value, dateFin.value, getValue())" data-dismiss="modal">
        </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
    </div>
    </div>
</div>';



    echo "<div class='modal fade' id='supp".$idPeriode."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'
        aria-hidden='true'>";
        echo "<div class='modal-dialog' role='document'>";
            echo "<div class='modal-content'>";
                echo "<div class='modal-body'>";
                    echo "Etes vous sur de vouloir supprimer la période du ".$dateDebut1." au ".$dateFin1." ?";
                echo "</div>";
                echo "<div class='modal-footer'>";
                    echo "<a type='button' class='btn btn-secondary' style='color: white' data-dismiss='modal'>Fermer</a>";

                    echo "<a type='button' class='btn btn-danger' style='color: white' onclick='suppressionPeriode(".$idPeriode.")' data-dismiss='modal'>Supprimer</a>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    echo "</div>";
 }
?>