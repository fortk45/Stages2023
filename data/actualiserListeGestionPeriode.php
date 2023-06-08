<?php
    include '../inc.connexion.php';

    $sqlperiode = " SELECT DISTINCT * FROM sta_periode p, sta_classe WHERE p.idclasse=sta_classe.idclasse ORDER BY p.date_debut desc;";
    $q = $connection->query($sqlperiode);
    $reponse = $q->fetchAll();
    
    
    foreach($reponse as $affiche){
        $idPeriode = $affiche['idperiode'];
        $debutPeriode = $affiche["date_debut"]; 
        $finPeriode = $affiche["date_fin"];
        $promoPeriode = $affiche["libelle_classe"];

        
        echo "<tr>";
        echo "<td>".$debutPeriode."</td>";
        echo "<td>".$finPeriode."</td>";
        echo "<td>".$promoPeriode."</td>";

        echo '<td><a class="btn btn-primary" class="btn btn-primary" data-toggle="modal"
        data-target="#modif'.$idPeriode.'" style="color: white"><i
            class="fa fa-edit"></i></a></td>';

        echo '<td><a class="btn btn-danger" class="btn btn-primary" data-toggle="modal"
                data-target="#supp'.$idPeriode.'" style="color: white"><i
                    class="fa fa-trash"></i></a></td>';

        echo "</tr>";

    }

?>