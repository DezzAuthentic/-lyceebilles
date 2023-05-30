<div class="titre">
    <span>Gestion de la classe <?=$groupe->nom?></span>
    <a id="ajout_btn" href="/academie/edt/classe/<?=$groupe->id?>" class="btn btn-default pull-right btn-sm">
        <span class="glyphicon glyphicon-calendar"></span> Emploi du temps
    </a>
</div>

<div class="row">

    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liste des cours
                <a id="ajout_btn" type="button" class="btn btn-default pull-right btn-xs" data-toggle="modal" data-target="#AjoutCoursModal">
                    <span class="glyphicon glyphicon-plus"></span> Ajouter un cours
                </a>
            </div>
            <table id="cours_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Matiere">Matière</th>
                        <th title="Professeur">Professeur</th>
                        <th title="heures par semaine">Heures par semaine</th>
                        <th class="actions" style="min-width:150px;">   
                        </th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=0; foreach($groupe->cours as $cour): ?>
                    <tr>
                        <td><?=$cour->matiere->nom?></td>
                        <td>Pr. <?=$cour->professeur->nom?> <?=$cour->professeur->prenom?></td>
                        <?php
                        $heures=0;
                        foreach($cour->edt as $seance){
                            $heures += $seance->duree;
                        }
                        $hr = (int) $heures;
                        $mn = ($heures - $hr) > 0 ?'30MN':'';
                        ?>
                        <td><?=$hr.'H '.$mn?></td>
                        <td class="actions">
                            <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>',['controller'=>'Cours','action' => 'fiche', $cour->id],['escape'=>false,'class' => 'btn btn-xs btn-warning'])?>
                            <?=$this->Form->postLink('<span class="glyphicon glyphicon-trash"></span>', ['controller'=>'Cours','action' => 'supprimer', $cour->id], ['escape'=>false,'confirm' => __('Voulez-vous supprimer ce cours # {0}?', $cour->id),'class'=>"btn btn-xs btn-danger"]); ?>
                        </td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">Liste des élèves</div>
            <table id="affectations_table" class="table datatable hover compact" >
                <thead>
                    <tr>
                        <th title="Matricule">Matricule</th>
                        <th title="Nom">Nom</th>
                        <th title="Prénom">Prénom</th>
                        <th title="Date de naissance">Date de naissance</th>
                        <th class="actions" style="min-width:180px;">   
                        </th>
                    </tr>
                </thead>
                <tbody>            
                <?php $i=0; foreach($groupe->affectations as $affectation): ?>
                    <tr>
                        <td><?=$affectation->inscription->elef->matricule?></td>
                        <td><?=$affectation->inscription->elef->nom?></td>
                        <td><?=$affectation->inscription->elef->prenom?></td>
                        <td><?=$affectation->inscription->elef->date_naissance?></td>
                        <td class="actions">
                            <?=$this->Html->link('Voir la fiche',['controller'=>'Eleves','action'=>'fiche',$affectation->inscription->elef->id],['class' => 'btn btn-xs btn-default'])?>
                            <?php if($affectation->inscription->etat != 'suspendu') echo $this->Html->link('<span class="">Suspendre</span>',['controller'=>"Inscriptions","action"=>'desactiver',$affectation->inscription->id],['escape'=>false,'confirm'=>__("Voulez-vous suspendre l'affectation de l'élève {0} {1}?",$affectation->inscription->elef->prenom,$affectation->inscription->elef->nom),'class' => 'btn btn-xs btn-default'])?>
                            <?php if($affectation->inscription->etat == 'suspendu') echo $this->Html->link('<span class="">&nbsp;Ré-activer </span>',['controller'=>"Inscriptions","action"=>'activer',$affectation->inscription->id],['escape'=>false,'confirm'=>__("Voulez-vous ré-actiiver l'affectation de l'élève {0} {1}?",$affectation->inscription->elef->prenom,$affectation->inscription->elef->nom),'class' => 'btn btn-xs btn-default'])?>
                        </td>
                    </tr>
                <?php $i++; endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liste des séances
            </div>
            <table id="seances_table" class="table datatable hover compact" >
            <thead>
                <tr>
                    <th title="Date">Date</th>
                    <th title="Matière">Matière</th>
                    <th title="retards">Retards</th>
                    <th title="absences">Absences</th>
                    <th title="renvois">Renvois</th>
                    <th title="Durée">Statut</th>
                    <th class="actions" style="min-width:130px;">   
                    </th>
                </tr>
            </thead>
            <tbody>            
            <?php $i=0; foreach($seances as $seance): ?>
                <tr>
                    <td><?=$seance->date?></td>
                    <td><?=$seance->cour->matiere->nom?></td>
                    <?php
                    $retards=0;
                    $absences=0;
                    $renvois=0;
                    foreach($seance->presences as $presence){
                        if($presence->type=='retard') $retards++;
                        elseif($presence->type=='absence') $absences++;
                        elseif($presence->type=='renvois') $renvois++;
                    }
                    ?>
                    <td><?=$retards?></td>
                    <td><?=$absences?></td>
                    <td><?=$renvois?></td>
                    <td><?=$seance->etat?></td>
                    <td class="actions">
                        <?=$this->Html->link('<span class="glyphicon glyphicon-eye-open"></span>',['controller'=>'Seances','action'=>"fiche",$seance->id],['escape'=>false,'class' => 'btn btn-xs btn-warning'])?>
                    </td>
                </tr>
            <?php $i++; endforeach;?>
            </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Ajout cours-->
<div class="modal fade" id="AjoutCoursModal" tabindex="-1" role="dialog" aria-labelledby="ajoutCoursModalLabel">
  <div class="modal-dialog" role="document">
    <form action="<?= $this->Url->Build(['controller' => 'Cours', 'action' => 'ajouter']) ?>" method="post">
        <div class="modal-content">
        <div class="modal-header bg-gray">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="AjoutCoursModalLabel">Ajouter un nouveau cours</h4>
        </div>
        <div class="modal-body">
            <input name="groupe_id" type="hidden" value="<?=$groupe->id?>"> 
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Matière</label>
                <div class="col-sm-8">
                    <select name="matiere_id" class="form-control" id="ajout_matiere">
                        <?php foreach($matieres as $matiere):?>
                            <option value="<?=$matiere->id?>" ><?=$matiere->nom?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div> 
            <div class="form-group row ">
                <label for="nom" class="col-sm-4">Professeur</label>
                <div class="col-sm-8">
                    <select name="professeur_id" class="form-control">
                        <option>Choisissez un professeur</option>
                        <?php foreach($professeurs as $professeur):?>
                            <option value="<?=$professeur->id?>" class="matiere
                            <?php foreach($professeur->enseignees as $ens){echo 'matiere-'.$ens->matiere_id.' ';}?>
                            " >Pr. <?=$professeur->nom?> <?=$professeur->prenom?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary" >Valider</button>
        </div>
        </div>
    </form>
  </div>
</div>

<?php
$this->Html->css([
    "https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css",
  ],
  ['block' => 'css']);

$this->Html->script([
    "https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js",
],
['block' => 'script']);
?>


<?php $this->start('scriptBottom'); ?>
<script>
$(document).ready( function () {
    $('#cours_table,#affectations_table').DataTable({
        "info": false,
        "paging": false,
        "order": [[1, "asc"]],
        "searching": false,
        "language": {
            "lengthMenu": "&nbsp; Afficher _MENU_ par page",
            "zeroRecords": "Pas d'enregistrement trouvé!",
            "info": "Page _PAGE_ sur _PAGES_",
            "infoEmpty": "Pas d'enregistrement disponible",
            "infoFiltered": "(filtrés sur _MAX_ enregistrements)",
            "search":         "Recherche",
            "scrollX": true,
            "paginate": {
                "first":      "<<",
                "last":       ">>",
                "next":       ">",
                "previous":   "<"
            }
        }
    });
    $('#seances_table').DataTable({
        "info": false,
        "paging": true,
        "order": [[1, "asc"]],
        "searching": false,
        "language": {
            "lengthMenu": "&nbsp; Afficher _MENU_ par page",
            "zeroRecords": "Pas d'enregistrement trouvé!",
            "info": "Page _PAGE_ sur _PAGES_",
            "infoEmpty": "Pas d'enregistrement disponible",
            "infoFiltered": "(filtrés sur _MAX_ enregistrements)",
            "search":         "Recherche",
            "scrollX": true,
            "paginate": {
                "first":      "<<",
                "last":       ">>",
                "next":       ">",
                "previous":   "<"
            }
        }
    });
    $('.matiere').hide();
    <?php if ($matieres->count() > 0):?>
    $('.matiere-<?=$matieres->toArray()[0]->id?>').show();
    <?php endif;?>
});
$("#ajout_matiere").change( function() {
    console.log("La matière a changé.");
    id = $("#ajout_matiere option:selected").val();
    $('.matiere').hide();
    console.log('.matiere-'+id);
    $('.matiere-'+id).show();
});
</script>
<?php $this->end(); ?>