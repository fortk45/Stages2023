<?php 
require 'verifAdmin.php';
include 'inc.header.php';


// REQUETE

$sqlperiode = "SELECT DISTINCT * FROM sta_periode p ORDER BY p.date_debut desc";
$q = $connection->query($sqlperiode);
$reponse = $q->fetchAll();



///!\/!\ NE PAS SUPPRIMER LAISSER POUR LE MOMENT /!\/!\echo '<div class="alert alert-danger" role="alert">La période à été supprimé.</div>'; /!\/!\ NE PAS SUPPRIMER LAISSER POUR LE MOMENT /!\/!\

?>



<!-- NavBar haut de l'écran -->
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Gestion périodes de stage </li>
        </ul>
    </div>
</div>

<!-- DEBUT Contenu affiché de de la page -->
<section class="">
    <div class="container-fluid">
        <header>
            <h1 class="h3 display">Gestion périodes de stage </h1>
        </header>

        <div class="card">
            <div class="card-header">
                <h4>Ajouter une période de stage <a data-toggle="modal" data-target="#exampleModal" class="btn btn-primary" style="color: white"><i class="fas fa-plus"></i></a></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date début</th>
                                <th>Date Fin</th>
                                <th>Promotion</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyPeriode">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</section>
<!-- FIN Contenu affiché de de la page -->

<!-- Modal -->
<!-- DEBUT Fenêtre Popup de suppression de la période -->
<div id="modaleSuppr">
    <!-- Div affichage modale suppression fichier référence : afficheModaleSuppr.php -->
</div>
<!-- FIN Fenêtre Popup de suppression de la période -->

<!-- Modal -->
<!-- DEBUT Fenêtre Popup d'ajout d'une période -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter une période de stage</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="get">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Date début:</label>
            <input type="date" class="form-control" name="dateDebut" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Date fin:</label>
            <input type="date" class="form-control" name="dateFin" id="recipient-name">
          </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Classe:</label><br>
                <select id="choixClasse" data-container="body" onchange="getValue();">
                <?php foreach (getClasseSio() as $ligne) {
                    echo "<option value=" . $ligne[0] . ">" . $ligne[1] . "</option>";
                } ?>
            </select>
            </div>
            <input type="button" value="Ajouter" class="btn btn-primary" onclick="ajoutPeriode(dateDebut.value, dateFin.value, getValue())" data-dismiss="modal">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<!-- FIN Fenêtre Popup d'ajout d'une période -->

<?php include 'inc.footer.php' ?>